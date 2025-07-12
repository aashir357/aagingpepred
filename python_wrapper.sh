#!/bin/bash
# Get directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"

# Set environment variables with absolute paths to ensure Python can find all packages
export PYTHONPATH="/opt/lampp/htdocs/cgntlab/aagingpepred/python_env/lib/python3.10/site-packages:/opt/lampp/htdocs/cgntlab/aagingpepred/python_packages:$PYTHONPATH"
export LD_LIBRARY_PATH="/usr/lib/x86_64-linux-gnu:${SCRIPT_DIR}/libs:$LD_LIBRARY_PATH"

# Print debugging info
echo "Python path: $PYTHONPATH"

# Execute Python with all arguments passed to this script
/opt/lampp/htdocs/cgntlab/aagingpepred/python_env/bin/python "$@"
exit $?