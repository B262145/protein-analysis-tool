#!/usr/bin/python3

import os
import sys
import subprocess
import pandas as pd
from Bio import Entrez, SeqIO
from Bio.Align.Applications import ClustalOmegaCommandline

# ------------------------------
# Step 1: Get User Input
# ------------------------------
protein_family = sys.argv[1]
taxonomic_group = sys.argv[2]
analysis_id = sys.argv[3]  # New: Get analysis ID from command line

print(f"Protein Family: {protein_family}")
print(f"Taxonomic Group: {taxonomic_group}")
print(f"Analysis ID: {analysis_id}")

# Create a directory for the analysis results
results_dir = f"analysis_{analysis_id}"
if not os.path.exists(results_dir):
    os.makedirs(results_dir)

# Change permissions of the results directory
try:
    subprocess.run(["chmod", "-R", "777", results_dir], check=True)
    print(f"Permissions changed successfully for '{results_dir}'.")
except subprocess.CalledProcessError as e:
    print(f"Failed to change permissions for '{results_dir}': {e}")
    sys.exit(1)  # Exit the script if permission change fails

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
    
    # Save sequences to a file in the results directory
    sequences_file = os.path.join(results_dir, "sequences.fasta")
    with open(sequences_file, "w") as f:
        f.write("\n".join(sequences))

    return ids

protein_ids = fetch_sequences(protein_family, taxonomic_group)
print(f"Retrieved {len(protein_ids)} sequences.")

# ------------------------------
# Step 3: Perform Multiple Sequence Alignment (MSA)
# ------------------------------
def run_alignment():
    aligned_file = os.path.join(results_dir, "aligned_sequences.fasta")
    clustalomega_cline = ClustalOmegaCommandline(infile=os.path.join(results_dir, "sequences.fasta"), outfile=aligned_file, verbose=True, auto=True, force=True)
    clustalomega_cline()
    print("Sequences aligned successfully!")
    return aligned_file

aligned_file = run_alignment()

# ------------------------------
# Step 4: Sequence Conservation Analysis
# ------------------------------
def plot_conservation(aligned_file):
    plotcon_output = os.path.join(results_dir, "conservation_plot")
    os.system(f"plotcon -sequences {aligned_file} -graph png -goutfile {plotcon_output} -winsize 10")
    print(f"Conservation plot saved as '{plotcon_output}.1.png'.")

plot_conservation(aligned_file)

# ------------------------------
# Step 5: Scan for Motifs using EMBOSS (patmatmotifs)
# ------------------------------
def scan_motifs():
    sequences = list(SeqIO.parse(os.path.join(results_dir, "sequences.fasta"), "fasta"))
    
    all_results = []
    for seq in sequences:
        clean_id = seq.id.replace("|", "_").replace(" ", "_")
        temp_fasta = os.path.join(results_dir, f"temp_{clean_id}.fasta")
        with open(temp_fasta, "w") as f:
            SeqIO.write(seq, f, "fasta")
        
        output_file = os.path.join(results_dir, f"motif_{clean_id}.txt")
        try:
            subprocess.run(f"patmatmotifs -sequence {temp_fasta} -outfile {output_file}", shell=True, check=True)
            with open(output_file, "r") as f:
                results = f.read()
            all_results.append(results)
        except subprocess.CalledProcessError as e:
            print(f"Error running patmatmotifs for sequence {seq.id}: {e}")
        finally:
            if os.path.exists(temp_fasta):
                os.remove(temp_fasta)
    
    motif_results_file = os.path.join(results_dir, "motif_results.txt")
    with open(motif_results_file, "w") as f:
        f.write("\n".join(all_results))
    print(f"Motif scanning complete! Results saved in '{motif_results_file}'.")

scan_motifs()

# ------------------------------
# Step 6: Analyze Protein Properties using PEPSTATS
# ------------------------------
def analyze_protein_properties():
    sequences = list(SeqIO.parse(os.path.join(results_dir, "sequences.fasta"), "fasta"))
    
    all_results = []
    for seq in sequences:
        clean_id = seq.id.replace("|", "_").replace(" ", "_")
        temp_fasta = os.path.join(results_dir, f"temp_{clean_id}.fasta")
        with open(temp_fasta, "w") as f:
            SeqIO.write(seq, f, "fasta")
        
        output_file = os.path.join(results_dir, f"pepstats_{clean_id}.txt")
        try:
            subprocess.run(f"pepstats -sequence {temp_fasta} -outfile {output_file}", shell=True, check=True)
            with open(output_file, "r") as f:
                results = f.read()
            all_results.append(results)
        except subprocess.CalledProcessError as e:
            print(f"Error running PEPSTATS for sequence {seq.id}: {e}")
        finally:
            if os.path.exists(temp_fasta):
                os.remove(temp_fasta)
    
    pepstats_results_file = os.path.join(results_dir, "pepstats_results.txt")
    with open(pepstats_results_file, "w") as f:
        f.write("\n".join(all_results))
    print(f"Protein properties analysis completed! Results saved in '{pepstats_results_file}'.")

analyze_protein_properties()

# ------------------------------
# Step 7: Generate Summary Report (CSV)
# ------------------------------
def generate_report():
    data = {
        "Protein Family": [protein_family],
        "Taxonomic Group": [taxonomic_group],
        "Number of Sequences": [len(protein_ids)],
        "Alignment File": [os.path.join(results_dir, "aligned_sequences.fasta")],
        "Conservation Plot": [os.path.join(results_dir, "conservation_plot.1.png")],
        "Motif Analysis": [os.path.join(results_dir, "motif_results.txt")],
        "Protein Properties": [os.path.join(results_dir, "pepstats_results.txt")],
    }
    df = pd.DataFrame(data)
    report_file = os.path.join(results_dir, "bioinformatics_report.csv")
    df.to_csv(report_file, index=False)
    print(f"Report generated as '{report_file}'.")

generate_report()

print("Analysis Complete! Check the generated files in the directory:")
print(f"- {results_dir}")
