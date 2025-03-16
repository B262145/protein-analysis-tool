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
print(f"Retrieved {len(protein_ids)} sequences.")

# ------------------------------
# Step 3: Perform Multiple Sequence Alignment (MSA)
# ------------------------------
def run_alignment():
    aligned_file = "aligned_sequences.fasta"
    clustalomega_cline = ClustalOmegaCommandline(infile="sequences.fasta", outfile=aligned_file, verbose=True, auto=True, force=True)
    clustalomega_cline()
    print("Sequences aligned successfully!")
    return aligned_file

aligned_file = run_alignment()

# ------------------------------
# Step 4: Sequence Conservation Analysis
# ------------------------------
def plot_conservation(aligned_file):
    if os.path.exists("conservation_plot.1.png"):
        os.remove("conservation_plot.1.png")
    
    # Use EMBOSS plotcon to generate conservation plot
    plotcon_output = "conservation_plot"
    os.system(f"plotcon -sequences {aligned_file} -graph png -goutfile {plotcon_output} -winsize 10")
    print("Conservation plot saved as 'conservation_plot.1.png'.")

plot_conservation(aligned_file)

# ------------------------------
# Step 5: Scan for Motifs using EMBOSS (patmatmotifs)
# ------------------------------
def scan_motifs():
    # Read the sequences from the FASTA file
    sequences = list(SeqIO.parse("sequences.fasta", "fasta"))
    
    # Run patmatmotifs for each sequence
    all_results = []
    for seq in sequences:
        # Clean the sequence ID to remove illegal characters
        clean_id = seq.id.replace("|", "_").replace(" ", "_")
        
        # Save the single sequence to a temporary file
        temp_fasta = f"temp_{clean_id}.fasta"
        with open(temp_fasta, "w") as f:
            SeqIO.write(seq, f, "fasta")
        
        # Run patmatmotifs on the temporary file
        output_file = f"motif_{clean_id}.txt"
        try:
            subprocess.run(f"patmatmotifs -sequence {temp_fasta} -outfile {output_file}", shell=True, check=True)
            
            # Read the patmatmotifs results
            with open(output_file, "r") as f:
                results = f.read()
            all_results.append(results)
        except subprocess.CalledProcessError as e:
            print(f"Error running patmatmotifs for sequence {seq.id}: {e}")
        finally:
            # Clean up temporary files
            if os.path.exists(temp_fasta):
                os.remove(temp_fasta)
            if os.path.exists(output_file):
                os.remove(output_file)
    
    # Save all results to a single file
    with open("motif_results.txt", "w") as f:
        f.write("\n".join(all_results))
    print("Motif scanning complete! Results saved in 'motif_results.txt'.")

scan_motifs()

# ------------------------------
# Step 6: Analyze Protein Properties using PEPSTATS
# ------------------------------
def analyze_protein_properties():
    # Read the sequences from the FASTA file
    sequences = list(SeqIO.parse("sequences.fasta", "fasta"))
    
    # Run PEPSTATS for each sequence
    all_results = []
    for seq in sequences:
        # Clean the sequence ID to remove illegal characters
        clean_id = seq.id.replace("|", "_").replace(" ", "_")
        
        # Save the single sequence to a temporary file
        temp_fasta = f"temp_{clean_id}.fasta"
        with open(temp_fasta, "w") as f:
            SeqIO.write(seq, f, "fasta")
        
        # Run PEPSTATS on the temporary file
        output_file = f"pepstats_{clean_id}.txt"
        try:
            subprocess.run(f"pepstats -sequence {temp_fasta} -outfile {output_file}", shell=True, check=True)
            
            # Read the PEPSTATS results
            with open(output_file, "r") as f:
                results = f.read()
            all_results.append(results)
        except subprocess.CalledProcessError as e:
            print(f"Error running PEPSTATS for sequence {seq.id}: {e}")
        finally:
            # Clean up temporary files
            if os.path.exists(temp_fasta):
                os.remove(temp_fasta)
            if os.path.exists(output_file):
                os.remove(output_file)
    
    # Save all results to a single file
    with open("pepstats_results.txt", "w") as f:
        f.write("\n".join(all_results))
    print("Protein properties analysis completed! Results saved in 'pepstats_results.txt'.")

analyze_protein_properties()

# ------------------------------
# Step 7: Generate Summary Report (CSV)
# ------------------------------
def generate_report():
    data = {
        "Protein Family": [protein_family],
        "Taxonomic Group": [taxonomic_group],
        "Number of Sequences": [len(protein_ids)],
        "Alignment File": [aligned_file],
        "Conservation Plot": ["conservation_plot.1.png"],
        "Motif Analysis": ["motif_results.txt"],
        "Protein Properties": ["pepstats_results.txt"],
    }
    df = pd.DataFrame(data)
    df.to_csv("bioinformatics_report.csv", index=False)
    print("Report generated as 'bioinformatics_report.csv'.")

generate_report()

print("Analysis Complete! Check the generated files:")
print("- sequences.fasta (retrieved sequences)")
print("- aligned_sequences.fasta (alignment output)")
print("- conservation_plot.1.png (visualization)")
print("- motif_results.txt (motif analysis)")
print("- pepstats_results.txt (protein properties)")
print("- bioinformatics_report.csv (summary)")
