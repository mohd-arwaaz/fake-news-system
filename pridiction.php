<?php
include "auth.php";
date_default_timezone_set("Asia/Kolkata");

/* ================= GET INPUT ================= */

$news = trim($_POST['news_text'] ?? '');
$search_type = $_POST['search_type'] ?? 'national';
$state = $_POST['state'] ?? null;
$national = $_POST['national'] ?? null;

if ($news == "") {
    header("Location: news.php");
    exit();
}

/* ================= TEXT PROCESSING ================= */

function preprocess($text) {
    $text = strtolower($text);
    $text = preg_replace("/[^a-z0-9\s]/", "", $text);
    $words = explode(" ", $text);

    // Remove small words
    $stopwords = ["the","is","at","which","on","and","a","an","of","in","to","for","with"];
    $words = array_diff($words, $stopwords);

    return array_filter($words);
}

function computeTF($words) {
    $tf = [];
    $total = count($words);
    if ($total == 0) return $tf;

    foreach ($words as $w) {
        $tf[$w] = ($tf[$w] ?? 0) + 1;
    }

    foreach ($tf as $w => $c) {
        $tf[$w] = $c / $total;
    }
    return $tf;
}

function computeIDF($docs) {
    $idf = [];
    $totalDocs = count($docs);

    foreach ($docs as $doc) {
        foreach (array_unique($doc) as $word) {
            $idf[$word] = ($idf[$word] ?? 0) + 1;
        }
    }

    foreach ($idf as $word => $count) {
        $idf[$word] = log($totalDocs / ($count + 1));
    }

    return $idf;
}

function computeTFIDF($tf, $idf) {
    $tfidf = [];
    foreach ($tf as $word => $value) {
        $tfidf[$word] = $value * ($idf[$word] ?? 0);
    }
    return $tfidf;
}

function cosineSimilarity($vec1, $vec2) {
    $dot = 0; $normA = 0; $normB = 0;

    $allWords = array_unique(array_merge(array_keys($vec1), array_keys($vec2)));

    foreach ($allWords as $word) {
        $v1 = $vec1[$word] ?? 0;
        $v2 = $vec2[$word] ?? 0;

        $dot += $v1 * $v2;
        $normA += $v1 * $v1;
        $normB += $v2 * $v2;
    }

    if ($normA == 0 || $normB == 0) return 0;

    return $dot / (sqrt($normA) * sqrt($normB));
}

/* ================= KEYWORD EXTRACTION ================= */

$query = urlencode(substr($news, 0, 150));


/* ================= TRUSTED DOMAINS ================= */

$national_domains = [
    "thehindu.com",
    "ndtv.com",
    "indianexpress.com",
    "bbc.com",
    "hindustantimes.com",
    "nypost.com",
    "theatlantic.com",
    "yahoo.com",
    "rt.com"
];


$state_domains = [

    "Andhra Pradesh" => [
        "eenadu.net", "sakshi.com", "andhrajyothy.com",
        "thehansindia.com", "deccanchronicle.com"
    ],

    "Arunachal Pradesh" => [
        "arunachaltimes.in", "echoofarunachal.in",
        "arunachalobserver.org"
    ],

    "Assam" => [
        "sentinelassam.com", "assamtribune.com",
        "pratidintime.com", "nenow.in"
    ],

    "Bihar" => [
        "prabhatkhabar.com", "livehindustan.com",
        "jagran.com", "bhaskar.com"
    ],

    "Chhattisgarh" => [
        "haribhoomi.com", "deshbandhu.co.in",
        "bhaskar.com", "naidunia.com"
    ],

    "Delhi" => [
        "navbharattimes.indiatimes.com",
        "hindustantimes.com",
        "timesofindia.indiatimes.com",
        "indianexpress.com"
    ],

    "Goa" => [
        "heraldgoa.in", "navhindtimes.in",
        "gomantaktimes.com"
    ],

    "Gujarat" => [
        "gujaratsamachar.com", "sandesh.com",
        "divyabhaskar.co.in", "timesofindia.indiatimes.com"
    ],

    "Haryana" => [
        "bhaskar.com", "amarujala.com",
        "tribuneindia.com"
    ],

    "Himachal Pradesh" => [
        "divyahimachal.com", "amarujala.com",
        "tribuneindia.com"
    ],

    "Jharkhand" => [
        "prabhatkhabar.com", "livehindustan.com",
        "jagran.com"
    ],

    "Karnataka" => [
        "vijaykarnataka.com", "prajavani.net",
        "udayavani.com", "deccanherald.com",
        "thehindu.com"
    ],

    "Kerala" => [
        "manoramaonline.com", "mathrubhumi.com",
        "deshabhimani.com", "newindianexpress.com"
    ],

    "Madhya Pradesh" => [
        "naidunia.jagran.com", "bhaskar.com",
        "jagran.com"
    ],

    "Maharashtra" => [
        "lokmat.com", "esakal.com",
        "maharashtratimes.com",
        "loksatta.com", "mid-day.com"
    ],

    "Manipur" => [
        "ifp.co.in", "thesangaiexpress.com",
        "imphaltimes.com"
    ],

    "Meghalaya" => [
        "theshillongtimes.com",
        "meghalayatimes.info",
        "nenow.in"
    ],

    "Mizoram" => [
        "vanglaini.org", "zozamtimes.com"
    ],

    "Nagaland" => [
        "nagalandpost.com",
        "easternmirrornagaland.com"
    ],

    "Odisha" => [
        "sambad.in", "dharitri.com",
        "thesamaja.com",
        "odishatv.in"
    ],

    "Punjab" => [
        "ajitjalandhar.com", "jagbani.com",
        "punjabkesari.in",
        "tribuneindia.com"
    ],

    "Rajasthan" => [
        "patrika.com", "bhaskar.com",
        "jagran.com"
    ],

    "Sikkim" => [
        "sikkimexpress.com", "summittimes.com"
    ],

    "Tamil Nadu" => [
        "dailythanthi.com", "dinamalar.com",
        "dinamani.com", "thehindu.com",
        "newindianexpress.com"
    ],

    "Telangana" => [
        "eenadu.net", "sakshi.com",
        "ntnews.com",
        "thehansindia.com"
    ],

    "Tripura" => [
        "tripuratimes.com", "dainiksambad.net"
    ],

    "Uttar Pradesh" => [
        "amarujala.com", "jagran.com",
        "livehindustan.com",
        "bhaskar.com"
    ],

    "Uttarakhand" => [
        "amarujala.com",
        "livehindustan.com",
        "jagran.com"
    ],

    "West Bengal" => [
        "anandabazar.com",
        "bartamanpatrika.com",
        "aajkaal.in",
        "telegraphindia.com"
    ]
];



if ($search_type === "national") {
    $trusted_domains = implode(",", $national_domains);
} else {
    $trusted_domains = isset($state_domains[$state])
        ? implode(",", $state_domains[$state])
        : implode(",", $national_domains);
}


/*=====news breaking===*/
$news = $_POST['news_text'];

$news = strip_tags($news);
$news = trim($news);

// Take only first 8 words
$words = explode(" ", $news);
$short_query = implode(" ", array_slice($words, 0, 5));


/* ================= NEWS API CALL ================= */

$apikey = "5c952cd47a2f4076875c0ce9d95315d4";
$url = "https://newsapi.org/v2/everything?q="
        . urlencode($short_query)
        . "&language=en"
        . "&sortBy=relevancy"
        . "&pageSize=10"
        . "&apiKey=" . $apikey;





$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


/* 🔥 IMPORTANT: Add User-Agent */
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: FakeNewsDetectionSystem/1.0'
]);

$response = curl_exec($ch);

if ($response === false) {
    die("cURL Error: " . curl_error($ch));
}

curl_close($ch);

$data = json_decode($response, true);



/*=====*/

$trusted_titles = [];
$trusted_sources = [];

if (!empty($data["articles"])) {

    foreach ($data["articles"] as $article) {

        $articleDomain = parse_url($article["url"], PHP_URL_HOST);

        // Remove www.
        $articleDomain = str_replace("www.", "", $articleDomain);

        if (in_array($articleDomain, $national_domains) ||
            in_array($articleDomain, $state_domains[$state] ?? [])) {

            $trusted_titles[] =
                ($article["title"] ?? "") . " " .
                ($article["description"] ?? "");

            $trusted_sources[] =
                ($article["source"]["name"] ?? "Trusted Source")
                . " | " .
                ($article["url"] ?? "");
        }
    }
}


/* ================= SIMILARITY ANALYSIS ================= */

$bestScore = 0;
$bestMatch = "No match found";
$bestSource = "N/A";
$similarCount = 0;
$totalSimilarity = 0;

if (!empty($trusted_titles)) {

    $userWords = preprocess($news);
    $trustedDocs = array_map("preprocess", $trusted_titles);

    $allDocs = array_merge([$userWords], $trustedDocs);
    $idf = computeIDF($allDocs);

    $userTFIDF = computeTFIDF(computeTF($userWords), $idf);

    foreach ($trustedDocs as $index => $doc) {

        $docTFIDF = computeTFIDF(computeTF($doc), $idf);
        $similarity = cosineSimilarity($userTFIDF, $docTFIDF);
        $percent = $similarity * 100;

        $totalSimilarity += $percent;

        if ($similarity > $bestScore) {
            $bestScore = $similarity;
            $bestMatch = $trusted_titles[$index];
            $bestSource = $trusted_sources[$index];
        }

        if ($percent >= 30) {
            $similarCount++;
        }
    }
}

$similarity_percent = round($bestScore * 100, 2);
$average_similarity = !empty($trusted_titles)
    ? round($totalSimilarity / count($trusted_titles), 2)
    : 0;

/* ================= DOMAIN PRIORITY CLASSIFICATION ================= */

$trusted_found = !empty($trusted_titles);

if ($trusted_found) {

    $status = "real";

    // Confidence based on similarity
    if ($similarity_percent >= 20) {
        $confidence = min(100, $similarity_percent + 30);
    } elseif ($similarity_percent >= 10) {
        $confidence = min(100, $similarity_percent + 20);
    } else {
        $confidence = 75; // Real but low similarity
    }

} else {

    $status = "fake";
    $confidence = 90;
}




/* ================= DATABASE SAVE ================= */

$conn = new mysqli("localhost", "root", "prince143", "books");

$stmt = $conn->prepare(
"INSERT INTO news_result 
(news_text, status, confidence, search_type, state, national, match_news_text, match_source)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
"ssssssss",
$news,
$status,
$confidence,
$search_type,
$state,
$national,
$bestMatch,
$bestSource
);

$stmt->execute();
$stmt->close();
$conn->close();





?>




<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', Arial, Helvetica, sans-serif;
}

/* ===== PAGE BACKGROUND ===== */
body {
  background-image: url("bg.jpg");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  animation: fadeIn 1.5s ease-in-out;

  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Fade animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ===== HEADER ===== */
header {
  background: linear-gradient(135deg,  rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 22px;
  text-align: center;
  font-size: 30px;
  font-weight: 700;
  color: white;
  backdrop-filter: blur(5px);
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
  animation: slideDown 1s ease-out;
}

@keyframes slideDown {
  from { transform: translateY(-50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== NAVIGATION BAR ===== */
nav {
  background: linear-gradient(135deg,rgba(15,196,154,0.7));
}

nav ul {
  list-style-type: none;
  display: flex;
  justify-content: center;
}

nav ul li a {
  display: block;
  color: white;
  padding: 14px 20px;
  text-decoration: none;
  font-size: 18px;
  font-weight: bold;
  transition: 0.3s;
}

nav ul li a:hover {
  background: rgba(255,255,255,0.2);
  border-radius: 8px;
}

/* ===== MAIN CONTENT ===== */
main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ===== RESULT CARD (GLASS STYLE) ===== */
.result-container {
  width: 55%;
  background: rgba(0, 0, 0, 0.6);
  padding: 30px;
  border-radius: 15px;
  backdrop-filter: blur(8px);
  box-shadow: 0px 6px 15px rgba(0,0,0,0.2);
  text-align: center;
  color:White;
  animation: zoomIn 1s ease-in-out;
}

@keyframes zoomIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

/* ===== STATUS BOX ===== */
.status {
  font-size: 22px;
  font-weight: bold;
  padding: 12px;
  border-radius: 10px;
  margin: 15px 0;
}

/* Real News */
.real {
  background-color: rgba(212, 237, 218, 0.9);
  color: #155724;
  border: 1px solid #c3e6cb;
}

/* Fake News */
.fake {
  background-color: rgba(248, 215, 218, 0.9);
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.suspicious {
  background-color: rgba(255, 243, 205, 0.9);
  color: #856404;
  border: 1px solid #ffeeba;
}


/* ===== TEXT STYLE ===== */
.result-container p {
  font-size: 16px;
  margin: 10px 0;
}

/* ===== BUTTON ===== */
.btn {
  display: block;
  margin: 25px auto 0;
  padding: 12px 30px;
  background: linear-gradient(135deg, rgba(15,196,154,0.7));
  color: white;
  border: none;
  border-radius: 25px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0px 0px 10px rgba(15,196,154,0.7);
}

.btn:hover {
  transform: scale(1.05);
}

/* ===== FOOTER ===== */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(12, 161, 136, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  font-size: 18px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 600px) {
  .result-container {
    width: 90%;
  }

  nav ul {
    flex-direction: column;
    text-align: center;
  }
}

</style>
</head>

<body>

<header>
  FAKE NEWS DETECTION SYSTEM
</header>

<nav>
<ul>
  <li><a href="home.php">HOME</a></li>
  <li><a href="register.php">REGISTER</a></li>
  <li><a href="news.php">DETECT NEWS</a></li>
</ul>
</nav>

<main>
<div class="result-container">
  <h2>News Detection Result</h2>

  <div class="status <?php echo $status; ?>">
   <?php
if ($status == "real") {
    echo "✅ Real News (Verified by Trusted Sources)";
} else {
    echo "❌ Fake News (No Trusted Source Found)";
}
?>


  </div>

  <p><strong>Confidence Score:</strong> <?php echo $confidence; ?>%</p>

  <?php if ($bestScore > 0): ?>
    <p><strong>Highest Similarity:</strong> <?php echo $similarity_percent; ?>%</p>

    <p><strong>Matched Trusted News:</strong></p>
    <div style="background:#f8f9fa; padding:10px; border-radius:8px; color:black;">
        <?php echo $bestMatch; ?>
    </div>

    <p><strong>Source:</strong> <?php echo $bestSource; ?></p>
<?php else: ?>
    <p>No similar trusted news found.</p>
<?php endif; ?>


  <p><strong>Summary:</strong>
  <?php
  echo $status == "real"
      ? "This news was verified using trusted news sources."
      : "This news could not be verified from trusted sources.";
  ?>
  </p>

  <p><strong>Date & Time:</strong> <?php echo date("d M Y, h:i A"); ?></p>

  <button class="btn" onclick="window.location.href='news.php'">
    Check Another News
  </button>
</div>
</main>

<footer>
  BE AWARE OF FAKE NEWS
</footer>

</body>
</html>
