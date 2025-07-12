
<?php
/**
 * local_config.php - System-specific configuration
 * 
 * This file contains configuration specific to this environment.
 * Do not commit this file to version control - each developer/server
 * should have their own version.
 */

return [
    // Python path - specific to your system
    'PYTHONPATH' => '/home/sangita/.local/lib/python3.12/site-packages',
    
    
     
     'PYTHON_EXECUTABLE' => '/opt/lampp/htdocs/cgntlab/aagingpepred/python_wrapper.sh',

    // Path to the prediction directory
    'PRED_DIR' => '/opt/lampp/htdocs/cgntlab/aagingpepred/Pred',
    
    // C++ Libraries path if needed
    'CPP_LIB_PATH' => '/lib/x86_64-linux-gnu',
    
    // MEME software directory
    'MEME_DIR' => '/home/cgntlab1/meme',
    
    // Project root directory
    'PROJECT_DIR' => '/opt/lampp/htdocs/cgntlab/aagingpepred',
    
    // Other environment-specific settings
    'DISPLAY_ERRORS' => '1',  // Set to '0' in production
    
    // If using miniconda
    'CONDA_DIR' => '/home/cgntlab1/miniconda3',
    
    // Temporary directories
    'TEMP_DIR' => '/opt/lampp/htdocs/cgntlab/aagingpepred/tmp',
    'DOWNLOADS_DIR' => '/opt/lampp/htdocs/cgntlab/aagingpepred/downloads',
    'RESULTS_DIR' => '/opt/lampp/htdocs/cgntlab/aagingpepred/results',
    
    // EMBOSS and sequence search tools
    'EMBOSS_DIR' => '/usr/bin',
    'SSEARCH_DIR' => '/usr/bin',
    
    // Web paths for downloads and other browser-accessible resources
    'WEB_BASE_PATH' => '/aagingpepred'
];


