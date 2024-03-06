<?php
// Number of quotes per page

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include __DIR__.'/../includes/db_connection.php';
include __DIR__.'/../includes/functions.php';

include __DIR__.'/../templates/header.php';

$quotesPerPage = 50;

// Determine the current page
$page = isset($page) ? $page : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $quotesPerPage;
if(isset($category)){
    $category = str_replace('-', ' ', $category);
}

if(isset($author)){
    $author = str_replace('-', ' ', $author);
}


// Fetch and display quotes based on the category
if (isset($category)) {
    
    $sql = "SELECT * FROM quotes WHERE status='approve' AND category = ? ORDER BY love DESC LIMIT $offset, $quotesPerPage";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

}else if(isset($author)){
    $sql = "SELECT * FROM quotes WHERE status='approve' AND author = ? ORDER BY love DESC LIMIT $offset, $quotesPerPage";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $author);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    // If no category specified, fetch all quotes
    // Fetch quotes for the current page
    $sql = "SELECT * FROM quotes WHERE status='approve' ORDER BY love DESC LIMIT $offset, $quotesPerPage";
    $result = $conn->query($sql);
}


    if (isset($category)) {
        echo '<h2 id="tagline">Discover Best '.$category.' Quotes</h2>'; 

    }else if(isset($author)){
        echo ' <h2 id="tagline">Discover Best '.$author.' Quotes</h2>'; 
    }else{
        echo ' <h2 id="tagline">Discover Best Quotes and sayings</h2>';
    }
    
    ?>

<div class="container-fluid quotes-list">
    <?php
        
        // Function to generate a random pastel color
        function generatePastelColor() {
            $base = mt_rand(0, 255);
            $range = 128;
            $r = mt_rand(max(0, $base - $range), min(255, $base + $range));
            $g = mt_rand(max(0, $base - $range), min(255, $base + $range));
            $b = mt_rand(max(0, $base - $range), min(255, $base + $range));
            return sprintf('#%02x%02x%02x', $r, $g, $b);
        }
    
        // Function to get contrast font color based on luminance of background color
        function getContrastColor($hexColor) {
            $hexColor = str_replace('#', '', $hexColor);
            $r = hexdec(substr($hexColor, 0, 2));
            $g = hexdec(substr($hexColor, 2, 2));
            $b = hexdec(substr($hexColor, 4, 2));
            $luminance = ($r * 0.299 + $g * 0.587 + $b * 0.114) / 255;
            return $luminance > 0.5 ? '#000000' : '#ffffff';
        }
        

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $randomColor = generatePastelColor();
                
                 // Create an associative array with divColor and fontColor
                $colorScheme = array(
                    'divColor' => $randomColor,
                    'fontColor' => getContrastColor($randomColor)
                );
                
                echo  

                "<div class=\"quote-container\" style=\"background-color:{$colorScheme['divColor']}; \";>". "<div style=\"background-color:{$colorScheme['divColor']};color:{$colorScheme['fontColor']} \"; class=\"image-quote\" id=\"{$row['id']}\">".
                    "<blockquote>{$row['quote']}</br></br><span class=\"author\">{$row['author']}</span></blockquote>"."</div>".
                    "<span class=\"love-button\" onclick=\"loveQuote({$row['id']})\">❤️</span>".
                    "<span style=\"color:{$colorScheme['fontColor']} \"; class=\"love-count\" id=\"love-count-{$row['id']}\">{$row['love']}</span>&nbsp;&nbsp;".
                    "<button style=\"color:{$colorScheme['fontColor']} \"; class=\"btn\" onclick=\"downloadImage({$row['id']})\">Download</button>".
                    "<button style=\"color:{$colorScheme['fontColor']} \"; class=\"btn\" onclick=\"copyQuote({$row['id']})\">Copy</button>".
                "</div>";

            }
        } else {
            echo "No quotes yet.";
        }
        ?>

    <div class="paging">
        <?php

        if(isset($category)){
            $category = str_replace(' ', '-', $category);
            // Previous button
            if ($page > 1) {
                echo "<a class=\"prev\" href=\"/category/".$category ."/page/". ($page - 1) . "\">Previous</a>";
            }

            // Next button
            if ($result->num_rows >= $quotesPerPage) {
                echo "<a  class=\"next\" href=\"/category/".$category ."/page/". ($page + 1) . "\">Next</a>";
            }
        }else if(isset($author)){
            $author = str_replace(' ', '-', $author);
                // Previous button
                if ($page > 1) {
                    echo "<a class=\"prev\" href=\"/author/".$author ."/page/" . ($page - 1) . "\">Previous</a>";
                }
    
                // Next button
                if ($result->num_rows >= $quotesPerPage) {
                    echo "<a  class=\"next\" href=\"/author/".$author ."/page/" . ($page + 1) . "\">Next</a>";
                }
        }else{
            // Previous button
            if ($page > 1) {
                echo "<a class=\"prev\" href=\"/page/" . ($page - 1) . "\">Previous</a>";
            }

            // Next button
            if ($result->num_rows >= $quotesPerPage) {
                echo "<a  class=\"next\" href=\"/page/" . ($page + 1) . "\">Next</a>";
            }
        }
        
        ?>
    </div>

</div>


<script>

    addEventListener("load", (event) => {
         let loveCount = localStorage.getItem("lovecount");
         if(!loveCount){
             localStorage.setItem("lovecount", JSON.stringify({}));
         }
        
    });
    
    function loveQuote(quoteId) {
        let loveCount = localStorage.getItem("lovecount");
        if(loveCount){
           loveCount= JSON.parse(loveCount);
            if(!loveCount[quoteId]){
                 ajaxCall(quoteId);
                 loveCount[quoteId]='T';
                 localStorage.setItem("lovecount", JSON.stringify(loveCount));
            }
        }
       
    }
    
    function ajaxCall(quoteId){
         // Use AJAX to update the love count in the database
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://quotesvalley.com/api', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update the love count in the UI
                    document.getElementById('love-count-' + quoteId).innerHTML = response.loveCount;
                } else {
                    console.error('Failed to update love count:', response.message);
                }
            }
        };

        // Send the quote ID as POST data
        let data = 'quote_id=' + quoteId;
        xhr.send(data);
    }
</script>

<?php
$conn->close();
include __DIR__.'/../templates/footer.php'; 
?>