import os
import subprocess

# Define the input multiple sequence alignment file and output directory
input_fasta = "aligned_sequences.fasta"  # Input aligned sequences in FASTA format

def run_iqtree(input_fasta):
    """
    Run IQ-TREE with only the -s parameter.
    """
    # Define the IQ-TREE command (only -s is used)
    iqtree_cmd = [
        "iqtree",                   # IQ-TREE command
        "-s", input_fasta,          # Input multiple sequence alignment file
    ]
    
    # Run IQ-TREE
    print("Running IQ-TREE with only -s parameter...")
    subprocess.run(iqtree_cmd, check=True)
    print("IQ-TREE analysis completed.")

def main():
    """
    Main function to execute the pipeline.
    """
    # Step 1: Run IQ-TREE to generate the phylogenetic tree
    run_iqtree(input_fasta)
    print(f"Phylogenetic analysis results saved.")

if __name__ == "__main__":
    # Execute the pipeline
    main()
