<?php
$selectedCountry = filter_input(INPUT_GET, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($selectedCountry)) {
    $selectedCountry = 'Ecuador';
}

$url = "http://universities.hipolabs.com/search?country=" . urlencode($selectedCountry);
$response = @file_get_contents($url);
$universities = $response ? json_decode($response, true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities Directory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-titles">
                <h1>Global Universities Directory</h1>
                <p>Currently viewing: <span><?= htmlspecialchars($selectedCountry) ?></span></p>
            </div>
            
            <div class="controls-container">
                <form method="GET" action="" class="country-form">
                    <input list="countryList" name="country" id="countryInput" value="<?= htmlspecialchars($selectedCountry) ?>" placeholder="Select or type a country..." required autocomplete="off">
                    <datalist id="countryList"></datalist>
                    <button type="submit" class="btn-primary">Load Data</button>
                </form>

                <div class="search-container">
                    <input type="text" id="search" placeholder="Filter current results...">
                </div>
            </div>
        </header>

        <main class="table-container">
            <table id="universitiesTable">
                <thead>
                    <tr>
                        <th>University Name</th>
                        <th>Domain</th>
                        <th>Website</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($universities)): ?>
                        <?php foreach ($universities as $uni): ?>
                            <tr>
                                <td><?= htmlspecialchars($uni["name"]) ?></td>
                                <td>
                                    <span class="badge"><?= htmlspecialchars(implode(", ", $uni["domains"])) ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($uni['web_pages'])): ?>
                                        <a href="<?= htmlspecialchars($uni['web_pages'][0]) ?>" target="_blank" rel="noopener noreferrer">
                                            <?= htmlspecialchars($uni['web_pages'][0]) ?>
                                        </a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="emptyStateRow">
                            <td colspan="3" class="empty-state">No universities found for this country.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="no-results" id="noResults">
                No matching records found in the current view.
            </div>
        </main>
    </div>
    
    <script src="functions.js"></script>
</body>
</html>
