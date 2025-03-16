<?php include 'includes/header.php'; ?>

<div class="container">
    <h1>About This Project</h1>
    <p>This project is a web-based application designed to provide comprehensive protein sequence analysis. Below is an overview of the implementation:</p>

    <h2>Backend Implementation</h2>
    <p>The core functionality of the application is implemented in Python. The backend performs the following tasks:</p>
    <ul>
        <li><strong>Sequence Retrieval</strong>: Fetches protein sequences from the NCBI database using the Biopython library.</li>
        <li><strong>Multiple Sequence Alignment (MSA)</strong>: Uses Clustal Omega to align sequences and identify conserved regions.</li>
        <li><strong>Conservation Analysis</strong>: Generates conservation plots using EMBOSS's <code>plotcon</code> tool.</li>
        <li><strong>Motif Scanning</strong>: Identifies functional motifs in protein sequences using EMBOSS's <code>patmatmotifs</code> tool.</li>
        <li><strong>Protein Properties Analysis</strong>: Calculates physicochemical properties using EMBOSS's <code>pepstats</code> tool.</li>
        <li><strong>Report Generation</strong>: Compiles analysis results into a CSV file using the Pandas library.</li>
    </ul>

    <h2>Frontend Implementation</h2>
    <p>The frontend is built using PHP, HTML, and CSS to provide a user-friendly interface. Key features include:</p>
    <ul>
        <li><strong>User Input</strong>: A web form allows users to specify a protein family and taxonomic group.</li>
        <li><strong>Result Display</strong>: Analysis results are displayed on the web page, including aligned sequences, conservation plots, motif analysis, and protein properties.</li>
        <li><strong>File Downloads</strong>: Users can download analysis results, such as FASTA files, plots, and reports.</li>
    </ul>

    <h2>Database Integration</h2>
    <p>A MySQL database is used to store user inputs and analysis results. This allows users to revisit their previous analyses and download results.</p>

    <h2>Web Server</h2>
    <p>The application is hosted on an Apache web server.</p>

    <h2>Technologies Used</h2>
    <ul>
        <li><strong>Programming Languages</strong>: Python, PHP, HTML, CSS</li>
        <li><strong>Libraries</strong>: Biopython, Pandas</li>
        <li><strong>Tools</strong>: Clustal Omega, EMBOSS (plotcon, patmatmotifs, pepstats)</li>
        <li><strong>Database</strong>: MySQL</li>
        <li><strong>Web Server</strong>: Apache</li>
    </ul>

</div>

<?php include 'includes/footer.php'; ?>
