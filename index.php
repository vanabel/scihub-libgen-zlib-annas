<?php
// Function to test website connectivity and extract metadata
function testWebsiteConnectivity($url) {
    // Set up context with user agent and timeout
    $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n",
            'timeout' => 10
        ),
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false
        )
    );
    $context = stream_context_create($opts);

    // Try to get the content
    try {
        $response = @file_get_contents($url, false, $context);
        if ($response !== false) {
            $metadata = extractSciHubMetadata($url, $context);
            $metadataClass = (strpos($metadata, 'Warning:') !== false) ? 'bg-warning' : 'bg-success';
            return array('status' => '✔', 'metadata' => $metadata, 'metadataClass' => $metadataClass);
        }
    } catch (Exception $e) {
        // Handle any exceptions
    }
    
    $errorMessage = error_get_last();
    if ($errorMessage) {
        $errorMessage = $errorMessage['message'];
        
        // Extract relevant part of the error message
        if (preg_match('/Failed to open stream: (.*)$/', $errorMessage, $matches)) {
            $errorMessage = trim($matches[1]);
        }
        if (preg_match('/php_network_getaddresses: (.*)$/', $errorMessage, $matches)) {
            $errorMessage = trim($matches[1]);
        }
        
        // Remove the URL prefix if present
        $urlPrefix = "file_get_contents(" . $url . "): ";
        if (strpos($errorMessage, $urlPrefix) === 0) {
            $errorMessage = substr($errorMessage, strlen($urlPrefix));
        }
    } else {
        $errorMessage = "Could not connect to the website";
    }
    
    return array('status' => '✘', 'metadata' => 'Error: ' . $errorMessage, 'metadataClass' => 'bg-danger');
}

// Function to extract metadata with specified keywords from description
function extractSciHubMetadata($url, $context) {
    try {
        // Try to get the actual page content
        $html = @file_get_contents($url, false, $context);
        if ($html === false) {
            return "Warning: Could not retrieve website content";
        }

        // Try to find title and description using regex
        $title = "";
        if (preg_match('/<title[^>]*>(.*?)<\/title>/i', $html, $matches)) {
            $title = trim($matches[1]);
        }

        $description = "";
        if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^>"\']*)["\'][^>]*>/i', $html, $matches) ||
            preg_match('/<meta[^>]*content=["\']([^>"\']*)["\'][^>]*name=["\']description["\'][^>]*>/i', $html, $matches)) {
            $description = trim($matches[1]);
        }

        if (empty($description) && !empty($title)) {
            return $title;
        } else if (!empty($description)) {
            $pattern = '/\bsci[\s-]?hub|research|papers|library|genesis|scientific|science\b/i';
            return preg_match($pattern, $description) 
                ? $description 
                : $description . "\nWarning: This website is not a genuine source for scientific content.";
        }

        return "Warning: No metadata found for the website";

    } catch (Exception $e) {
        return "Warning: Error extracting metadata";
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    header('Content-Type: application/json');
    echo json_encode(testWebsiteConnectivity($_POST['url']));
    exit;
}

// Handle direct access to test a specific site
if (isset($_GET['test']) && $_GET['test'] === 'scihub') {
    $scihubSites = array(
        "https://sci-hub.se",
        "https://sci-hub.do",
        "https://sci-hub.cc",
        "https://sci-hub.st",
        "https://sci-hub.it.nf",
        "https://sci-hub.es.ht",
        "https://sci-hub.im",
        "https://sci-hub.tw",
        "https://sci-hub.si",
        "https://sci-hub.ru",
        "https://sci-hub.hkvisa.net",
        "https://sci-hub.tw"
    );
    $websites = $scihubSites;
} else if (isset($_GET['test']) && $_GET['test'] === 'libgen') {
    $libgenSites = array(
        "https://libgen.is",
        "https://libgen.top",
        "https://libgen.click",
        "https://libgen.gs",
        "https://libgen.me",
        "https://gen.lib.rus.ec",
        "https://libgen.unblockit.id",
        "https://libgen.unblocked.pet",
        "https://libgen.st",
        "https://libgen.rs",
        "https://libgen.li",
        "https://libgen.io",
        "https://libgen.be",
        "https://libgen.nl",
        "https://libgen.gs",
        "https://libgen.lc"
    );
    $websites = $libgenSites;
} else if (isset($_GET['test']) && $_GET['test'] === 'annas') {
    $annasArchiveSites = array(
        "https://annas-archive.org",
        "https://anna.noblogs.org",
        "https://annas-archive.se",
        "https://annas-archive.gs",
        "https://annas-archive.ee",
        "https://annas-archive.ro",
        "https://annas-archive.ch"
    );
    $websites = $annasArchiveSites;
} else if (isset($_GET['test']) && $_GET['test'] === 'zlibrary') {
    $zLibrarySites = array(
        "https://z-library.se",
        "https://zlibrary.to",
        "https://1lib.sk",
        "https://1lib.ch",
        "https://singlelogin.re",
        "https://1lib.education",
        "https://1lib.cloud",
        "https://1lib.domains",
        "https://zlibrary.org",
        "https://bookszlibb74ugqojhzhg2a63w5i2atv5bqarulgczawnbmsb6s6qead.onion.ly",
        "https://zlibrary.unblockit.rsvp",
        "https://zlibrary.unblockit.bet"
    );
    $websites = $zLibrarySites;
}

// Handle AJAX requests for connectivity testing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkUrl'])) {
    header('Content-Type: application/json');
    
    $url = $_POST['checkUrl'];
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0.4472.124',
        CURLOPT_HTTPHEADER => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.8'
        ]
    ]);
    
    try {
        $startTime = microtime(true);
        $response = curl_exec($ch);
        $endTime = microtime(true);
        
        if ($response === false) {
            throw new Exception(curl_error($ch));
        }
        
        $info = curl_getinfo($ch);
        $headerSize = $info['header_size'];
        $body = substr($response, $headerSize);
        
        // Get page title
        $title = '';
        if (preg_match('/<title[^>]*>(.*?)<\/title>/i', $body, $matches)) {
            $title = trim(strip_tags($matches[1]));
        }
        
        echo json_encode([
            'success' => true,
            'statusCode' => $info['http_code'],
            'connectTime' => round($info['connect_time'] * 1000),
            'totalTime' => round($info['total_time'] * 1000),
            'title' => $title,
            'size' => $info['size_download'],
            'speed' => round($info['speed_download'] / 1024, 2) . ' KB/s',
            'primaryIP' => $info['primary_ip'],
            'redirectCount' => $info['redirect_count'],
            'redirectUrl' => $info['redirect_url']
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    } finally {
        curl_close($ch);
    }
    exit;
}

// Update the title based on the test parameter
$title = isset($_GET['test']) 
    ? ($_GET['test'] === 'scihub' 
        ? 'Sci-Hub' 
        : ($_GET['test'] === 'libgen' 
            ? 'Library Genesis'
            : ($_GET['test'] === 'annas'
                ? 'Anna\'s Archive'
                : 'Z-Library'))) 
    : 'Sci-Hub, Library Genesis, Anna\'s Archive and Z-Library';

// Get saved URLs from cookie
$savedUrls = isset($_COOKIE['test_urls']) ? json_decode($_COOKIE['test_urls'], true) : array();

// Handle URL submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_url'])) {
    $newUrl = filter_var($_POST['new_url'], FILTER_SANITIZE_URL);
    if (filter_var($newUrl, FILTER_VALIDATE_URL)) {
        if (!in_array($newUrl, $savedUrls)) {
            $savedUrls[] = $newUrl;
            // Save for 30 days
            setcookie('test_urls', json_encode($savedUrls), time() + (30 * 24 * 60 * 60), '/');
        }
    }
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['test']) ? '?test=' . $_GET['test'] : ''));
    exit;
}

// Handle URL deletion
if (isset($_GET['delete'])) {
    $index = intval($_GET['delete']);
    if (isset($savedUrls[$index])) {
        array_splice($savedUrls, $index, 1);
        setcookie('test_urls', json_encode($savedUrls), time() + (30 * 24 * 60 * 60), '/');
    }
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['test']) ? '?test=' . $_GET['test'] : ''));
    exit;
}

// Add saved URLs to the websites array
if (!empty($savedUrls)) {
    $websites = array_merge($websites, $savedUrls);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?> Connectivity Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; vertical-align: middle; }
        th { 
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        .status-cell {
            font-weight: bold;
            text-align: center;
            width: 100px;
        }
        .metadata-cell { font-size: 14px; }
        .bg-warning { background-color: #f0ad4e; }
        .bg-error { background-color: #d9534f; }
        .nowrap { white-space: nowrap; }
        th[style*="cursor: pointer"]:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>The Connectivity of <?php echo $title; ?> from Your Browser</h1>
                <p class="text-muted">Testing connectivity from your location to the websites...</p>
            </div>
        </div>

        <!-- Add URL Form -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Custom URL for Testing</h5>
                        <form method="POST" class="form-inline justify-content-center">
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="url" class="form-control" name="new_url" 
                                       placeholder="https://example.com" required 
                                       pattern="https?://.+" title="Include http:// or https://">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Add URL</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom URLs List -->
        <?php if (!empty($savedUrls)): ?>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Your Custom URLs</h5>
                        <ul class="list-group">
                            <?php foreach ($savedUrls as $index => $url): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($url); ?>
                                <a href="?delete=<?php echo $index; ?><?php echo isset($_GET['test']) ? '&test=' . htmlspecialchars($_GET['test']) : ''; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to remove this URL?')">
                                    Remove
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Website</th>
                            <th>Status</th>
                            <th style="cursor: pointer" title="Click to sort by response time">
                                Response Time 
                                <span class="small">↕</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="resultsTable"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function testSiteConnectivity(url) {
            return new Promise((resolve) => {
                const startTime = performance.now();
                const timeout = 10000; // 10 second timeout
                
                // Create a fetch request with timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), timeout);
                
                fetch(url, {
                    mode: 'no-cors',
                    signal: controller.signal
                })
                .then(() => {
                    clearTimeout(timeoutId);
                    const endTime = performance.now();
                    resolve({
                        status: '✔',
                        responseTime: Math.round(endTime - startTime) + 'ms',
                        class: 'bg-success'
                    });
                })
                .catch(() => {
                    clearTimeout(timeoutId);
                    resolve({
                        status: '✘',
                        responseTime: 'Failed to connect',
                        class: 'bg-danger'
                    });
                });
            });
        }

        function addResultToTable(url, result) {
            const timeValue = result.responseTime === 'Failed to connect' ? 
                result.responseTime : 
                parseInt(result.responseTime);
            
            $('#resultsTable').append(
                '<tr>' +
                '<td><a href="' + url + '" target="_blank">' + url + '</a></td>' +
                '<td class="status-cell">' + result.status + '</td>' +
                '<td class="metadata-cell ' + result.class + '" data-time="' + timeValue + '">' + 
                    result.responseTime + '</td>' +
                '</tr>'
            );
        }

        async function testAndAddToTable(url) {
            const result = await testSiteConnectivity(url);
            addResultToTable(url, result);
        }

        function sortTable() {
            const table = document.getElementById('resultsTable');
            const rows = Array.from(table.getElementsByTagName('tr'));
            
            // Sort the rows
            rows.sort((a, b) => {
                const aTime = parseResponseTime(a.cells[2].textContent);
                const bTime = parseResponseTime(b.cells[2].textContent);
                
                // Handle 'Failed to connect' cases
                if (aTime === -1) return 1;
                if (bTime === -1) return -1;
                
                return aTime - bTime;
            });
            
            // Re-append rows in sorted order
            rows.forEach(row => table.appendChild(row));
        }

        // Helper function to parse response time
        function parseResponseTime(timeStr) {
            if (timeStr === 'Failed to connect') return -1;
            return parseInt(timeStr);
        }

        // Update the table header to include sorting functionality
        function initializeSortableTable() {
            const headerRow = document.querySelector('table thead tr');
            const timeHeader = headerRow.cells[2];
            timeHeader.style.cursor = 'pointer';
            timeHeader.title = 'Click to sort by response time';
            timeHeader.addEventListener('click', sortTable);
        }

        $(document).ready(function() {
            initializeSortableTable();
            <?php foreach ($websites as $website): ?>
                testAndAddToTable('<?php echo $website; ?>');
            <?php endforeach; ?>
        });
    </script>
</body>
</html>
