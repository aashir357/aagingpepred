 print("Checking for modlamp...")
    import modlamp
    print("✓ modlamp is installed (version: {})".format(modlamp.__version__))
except ImportError:
    print("✗ modlamp is NOT installed")

try:
    print("\nChecking for scikit-learn...")
    import sklearn
    print("✓ scikit-learn is installed (version: {})".format(sklearn.__version__))
except ImportError:
    print("✗ scikit-learn is NOT installed")

print("\nPython path:")
import sys
for path in sys.path:
    print("  - {}".format(path))
