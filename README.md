# aagingpepred

**Description:**

AgingBasePEPred is a machine learning-powered web application designed to predict whether a given peptide exhibits anti-aging or aging properties. Built with a focus on biological relevance and model robustness, the project leverages multiple ML techniques to deliver accurate, real-time classification through a user-friendly web interface.

**Goal of the project:**

The goal of this project was to evaluate various machine learning models on a curated dataset of peptides and identify the best-performing approach for predicting anti-aging potential. We focused on feature engineering from biological data and deployed the top-performing model onto a custom web server.

**About The Model:**

The tool is capable of accepting peptide sequences in Fasta format, with lengths ranging from 5 to 50 amino acid residues.
A predictive model for assessing peptide anti-aging potential requires balanced datasets. We sourced 216 positive peptides from AagingBase and generated an equivalent negative dataset of 216 peptides using Python's random library. This balanced dataset facilitates model development.
We developed a prediction model for anti-aging peptides using various AI/ML algorithms. The algorithms employed in this study included Support Vector Machine (SVM), Random Forest Classification (RFC), XG Boost (XGB), and Multilayer Perceptron (MLP). Among these algorithms, XG Boost (XGB) demonstrated the highest accuracy for both the training and test datasets, achieving an accuracy of 80%. Based on this outcome, XGB was selected as the preferred model for further analysis, specifically in the context of AagingPEPred.


Web server link: https://project.iith.ac.in/cgntlab/aagingpepred/

