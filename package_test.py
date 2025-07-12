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