<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include config
$config = require_once __DIR__ . '/config.php';

// Get paths
$pythonExe = getenv('PYTHON_EXECUTABLE');
$predDir = getenv('PRED_DIR');

// Print environment info
echo "Python executable: {$pythonExe}<br>";
echo "LD_LIBRARY_PATH: " . getenv('LD_LIBRARY_PATH') . "<br>";
echo "PYTHONPATH: " . getenv('PYTHONPATH') . "<br>";
echo "Working directory: " . getcwd() . "<br>";

// Create a simple Python test
$testScript = __DIR__ . '/python_test.py';
file_put_contents($testScript, "print('Python is working')");

// Try to execute Python
echo "Running test script...<br>";
$output = shell_exec($pythonExe . ' ' . $testScript . ' 2>&1');
echo "Output: {$output}<br>";

// Create a package import test
$packageTestScript = __DIR__ . '/package_test.py';
$packageTest = <<<'EOT'
try:
    import sys
    print("Python path:")
    for path in sys.path:
        print(f"  - {path}")
    
    print("\nTrying to import packages:")
    
    import pandas as pd
    print("✓ pandas imported successfully")
    
    import numpy as np
    print("✓ numpy imported successfully")
    
    import xgboost as xgb
    print("✓ xgboost imported successfully")
    
    from scipy import stats
    print("✓ scipy imported successfully")
    
    from Bio import SeqIO
    print("✓ biopython imported successfully")
    
    print("\nAll packages imported successfully!")
except ImportError as e:
    print(f"Error importing packages: {e}")
EOT;

file_put_contents($packageTestScript, $packageTest);
echo "Testing package imports...<br>";
$packageOutput = shell_exec($pythonExe . ' ' . $packageTestScript . ' 2>&1');
echo "Output: {$packageOutput}<br>";

// Try to execute the problematic script with verbose output
echo "Running model prediction script with verbose output...<br>";
chdir($predDir . '/peptide');
echo "Changed directory to: " . getcwd() . "<br>";

// Check if the Python file exists
if (file_exists('model_prediction_all_features_random.py')) {
    echo "Model script file exists.<br>";
} else {
    echo "WARNING: Model script file does not exist!<br>";
}

// Create a wrapper that adds debugging
$debugWrapperScript = $predDir . '/peptide/debug_wrapper.py';
$debugWrapperContent = <<<'EOT'
import sys
import os

print("Python executable:", sys.executable)
print("Python version:", sys.version)
print("Current directory:", os.getcwd())
print("Files in current directory:", os.listdir('.'))

print("\nAttempting to run model_prediction_all_features_random.py")
try:
    import model_prediction_all_features_random
    print("Script imported successfully")
except Exception as e:
    print(f"Error running script: {e}")
    import traceback
    traceback.print_exc()
EOT;

file_put_contents($debugWrapperScript, $debugWrapperContent);
echo "Created debug wrapper script.<br>";

$output = shell_exec($pythonExe . ' ' . $debugWrapperScript . ' 2>&1');
echo "Output: {$output}<br>";

// Check for prediction.csv
if (file_exists($predDir . '/peptide/prediction.csv')) {
    echo "prediction.csv exists. Contents:<br>";
    echo "<pre>" . htmlspecialchars(file_get_contents($predDir . '/peptide/prediction.csv')) . "</pre>";
} else {
    echo "prediction.csv does not exist.<br>";
}


// Added this to debug_python.php
echo "Running simplified test model script...<br>";
$output = shell_exec($pythonExe . ' ' . $predDir . '/peptide/test_model.py 2>&1');
echo "Output: {$output}<br>";


?>