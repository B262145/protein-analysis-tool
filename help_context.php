<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>Help & Context</h1>
    <p>Welcome to the Protein Sequence Analysis Tool! This tool is designed to help you analyze protein sequences efficiently. Below is an overview of the implementation:</p>

    <h2>Tool Overview</h2>
    <p>The tool integrates with the NCBI database, Biopython, and EMBOSS to provide the following analyses:</p>
    <ul>
        <li><strong>Sequence Retrieval</strong>: Fetch protein sequences from the NCBI database based on a specified protein family and taxonomic group.</li>
        <li><strong>Multiple Sequence Alignment (MSA)</strong>: Align multiple protein sequences to identify conserved regions and variations.</li>
        <li><strong>Conservation Analysis</strong>: Visualize the conservation of amino acids across the aligned sequences.</li>
        <li><strong>Motif Scanning</strong>: Scan protein sequences for known functional motifs from the PROSITE database.</li>
        <li><strong>Protein Properties Analysis</strong>: Calculate physicochemical properties of protein sequences, such as molecular weight, isoelectric point, and amino acid composition.</li>
        <li><strong>Summary Report</strong>: Generate a comprehensive report summarizing all analysis results.</li>
    </ul>

    <h2>How to Use the Tool</h2>
    <p>Follow these steps to analyze protein sequences:</p>
    <ol>
        <li><strong>Input</strong>:
            <ul>
                <li>Enter a protein family (e.g., "glucose-6-phosphatase") and a taxonomic group (e.g., "Aves") in the input form.</li>
                <li>Click the "Analyze" button to start the analysis.</li>
            </ul>
        </li>
        <li><strong>Analysis</strong>:
            <ul>
                <li>The tool will automatically fetch sequences from the NCBI database.</li>
                <li>It will perform multiple sequence alignment, conservation analysis, motif scanning, and protein properties analysis.</li>
            </ul>
        </li>
        <li><strong>Output</strong>:
            <ul>
                <li>View the results on the results page, including aligned sequences, conservation plots, motif analysis, and protein properties.</li>
                <li>Download the results as files (e.g., FASTA files, plots, and CSV reports).</li>
            </ul>
        </li>
    </ol>

    <h2>Biological Rationale</h2>
    <p>Understanding protein sequences is crucial for studying their structure, function, and evolutionary relationships. This tool helps you:</p>
    <ul>
        <li><strong>Identify Conserved Regions</strong>: Highly conserved regions often indicate functional or structural importance.</li>
        <li><strong>Discover Functional Motifs</strong>: Motifs are short, conserved sequences that often correspond to functional domains or binding sites.</li>
        <li><strong>Analyze Protein Properties</strong>: Physicochemical properties influence protein stability, solubility, and interactions.</li>
    </ul>

    <h2>Frequently Asked Questions (FAQ)</h2>
    <p><strong>Q: What is the maximum number of sequences I can analyze?</strong><br>
    A: The tool currently retrieves up to 10 sequences from the NCBI database to ensure efficient analysis.</p>

    <p><strong>Q: Can I download the results?</strong><br>
    A: Yes, you can download all analysis results, including aligned sequences, plots, and reports.</p>
</div>

<?php include 'includes/footer.php'; ?>
