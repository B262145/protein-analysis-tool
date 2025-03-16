#!/usr/bin/python3

import os
import sys
import requests
import pandas as pd
import matplotlib.pyplot as plt
from Bio import Entrez, SeqIO
from Bio.Align.Applications import ClustalOmegaCommandline

# ------------------------------
# Step 1: Get User Input
# ------------------------------
protein_family = sys.argv[1]
taxonomic_group = sys.argv[2]

print(f"Protein Family: {protein_family}")
print(f"Taxonomic Group: {taxonomic_group}")

# Set NCBI email and API key
Entrez.email = "wsmcfyh@gmail.com"
Entrez.api_key = "8f9d60e149c966b3fa8b163d282d32a4a208"

# ------------------------------
# Step 2: Fetch Protein Sequences from NCBI
# ------------------------------
def fetch_sequences(protein_family, taxonomic_group):
    query = f'"{protein_family}"[Protein Name] AND "{taxonomic_group}"[Organism]'
    handle = Entrez.esearch(db="protein", term=query, retmax=10)  # Limit results
    record = Entrez.read(handle)
    ids = record["IdList"]
    
    sequences = []
    for protein_id in ids:
        handle = Entrez.efetch(db="protein", id=protein_id, rettype="fasta", retmode="text")
        seq_data = handle.read()
        sequences.append(seq_data)
    
    # Save sequences to a file
    with open("sequences.fasta", "w") as f:
        f.write("\n".join(sequences))

    return ids

protein_ids = fetch_sequences(protein_family, taxonomic_group)
print(f"âœ” Retrieved {len(protein_ids)} sequences.")

# ------------------------------
# Step 3: Perform Multiple Sequence Alignment (MSA)
# ------------------------------
def run_alignment():
    aligned_file = "aligned_sequences.fasta"
    clustalomega_cline = ClustalOmegaCommandline(infile="sequences.fasta", outfile=aligned_file, verbose=True, auto=True, force=True)
    clustalomega_cline()
    print("âœ” Sequences aligned successfully!")
    return aligned_file

aligned_file = run_alignment()

# ------------------------------
# Step 4: Sequence Conservation Analysis (Plot Conservation Score)
# ------------------------------
# Delete the old file
if os.path.exists("conservation_plot.1.png"):
    os.remove("conservation_plot.1.png")

def plot_conservation(aligned_file):
    # Use EMBOSS plotcon to generate conservation plot
    plotcon_output = "conservation_plot"  # PostScript output file
    os.system(f"plotcon -sequences {aligned_file} -graph png -goutfile {plotcon_output} -winsize 10")  # Set window size to 10
    print("âœ” Conservation plot saved as 'conservation_plot.1.png'.")

plot_conservation(aligned_file)

# ------------------------------
# Step 5: Scan for Motifs using EMBOSS (patmatmotifs)
# ------------------------------
def scan_motifs():
    os.system("patmatmotifs -sequence sequences.fasta -outfile motifs_results.txt")
    print("âœ” Motif scanning complete! Results saved in 'motifs_results.txt'.")

scan_motifs()

# ------------------------------
# Step 6: Generate Summary Report (CSV)
# ------------------------------
def generate_report():
    data = {
        "Protein Family": [protein_family],
        "Taxonomic Group": [taxonomic_group],
        "Number of Sequences": [len(protein_ids)],
        "Alignment File": [aligned_file],
        "Conservation Plot": ["conservation_plot.png"],
        "Motif Analysis": ["motifs_results.txt"]
    }
    df = pd.DataFrame(data)
    df.to_csv("bioinformatics_report.csv", index=False)
    print("âœ” Report generated as 'bioinformatics_report.csv'.")

generate_report()

print("\nðŸŽ‰ Analysis Complete! Check the generated files:")
print("- sequences.fasta (retrieved sequences)")
print("- aligned_sequences.fasta (alignment output)")
print("- conservation_plot.1.png (visualization)")
print("- motifs_results.txt (motif analysis)")
print("- bioinformatics_report.csv (summary)")
