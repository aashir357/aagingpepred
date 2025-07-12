#!/bin/bash

# Define project base directory
PROJECT_DIR="/opt/lampp/htdocs/cgntlab/aagingpepred"

# Apache user (adjust if it's not 'daemon')
APACHE_USER="daemon"  # (apache user is "cgntlab1" in cgntlab1 system)

echo "📁 Setting ownership to $APACHE_USER for necessary directories..."

sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/peptide"
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/pep_card"
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/motif_scanning"
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/protein_mutant"
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/protein_scanning"
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/design"
sudo chown -R $APACHE_USER:$APACHE_USER "$PROJECT_DIR/Pred/mutant_card"


echo "🔒 Setting permissions on downloads and output directories..."

sudo chmod -R 755 "$PROJECT_DIR/Pred/peptide"
sudo chmod -R 755 "$PROJECT_DIR/Pred/pep_card"
sudo chmod -R 755 "$PROJECT_DIR/Pred/motif_scanning"
sudo chmod -R 755 "$PROJECT_DIR/Pred/protein_mutant"
sudo chmod -R 755 "$PROJECT_DIR/Pred/protein_scanning"
sudo chmod -R 755 "$PROJECT_DIR/Pred/design"
sudo chmod -R 755 "$PROJECT_DIR/Pred/mutant_card"

echo "🚀 Making all .sh scripts executable..."
sudo find "$PROJECT_DIR/Pred" -name "*.sh" -exec chmod 755 {} \;

echo "🐍 Setting safe permissions for .py scripts..."
sudo find "$PROJECT_DIR/Pred" -name "*.py" -exec chmod 755 {} \;

echo "✅ Permissions setup complete."

