<?php
session_start();
// Function to generate a mathematical CAPTCHA
function generateMathCaptcha() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $operator = ['+', '-', '*'][array_rand(['+', '-', '*'])];
    $captcha = "$num1 $operator $num2";
    $_SESSION['math_captcha'] = eval("return $captcha;"); // Store the result in the session
    return $captcha;
}
?>

<!-- The Modal -->
<div id="quoteModal">
    <div class="modal-box">
        <span onclick="closeModal()" style="cursor: pointer; float: right;">&times;</span>
        <h2>Submit a Quote</h2>
        <p>Submitted Quotes will appear after approval. </p>
        <form action="submitquotes" method="post">
            <label for="quote">Quote:</label>
            <textarea name="quote" id="quote" required></textarea><br>

            <label for="author">Author:</label>
            <input type="text" name="author" id="author"><br>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="" disabled selected>Select a category</option>
                <option value="Ability">Ability Quotes</option>
                <option value="Inspiration">Inspiration</option>
                <option value="Motivation">Motivation</option>
                <option value="Love">Love</option>
                <option value="Friendship">Friendship</option>
                <option value="Life">Life</option>
                <option value="Wisdom">Wisdom</option>
                <option value="Success">Success</option>
                <option value="Happiness">Happiness</option>
                <option value="Humor">Humor</option>
                <option value="Courage">Courage</option>
                <option value="Faith">Faith</option>
                <option value="Hope">Hope</option>
                <option value="Positive">Positive</option>
                <option value="Leadership">Leadership</option>
                <option value="Family">Family</option>
                <option value="Gratitude">Gratitude</option>
                <option value="Perseverance">Perseverance</option>
                <option value="Change">Change</option>
                <option value="Education">Education</option>
                <option value="Time">Time</option>
                <option value="Forgiveness">Forgiveness</option>
                <option value="Nature">Nature</option>
                <option value="Imagination">Imagination</option>
                <option value="Passion">Passion</option>
                <option value="Health">Health</option>
                <option value="Creativity">Creativity</option>
                <option value="Knowledge">Knowledge</option>
                <option value="Spirituality">Spirituality</option>
                <option value="Technology">Technology</option>
                <option value="Hindi">Hindi Quotes</option>
            </select>

            <!-- Mathematical CAPTCHA input -->
            <label for="captcha">Human Check? <?php echo generateMathCaptcha(); ?></label>
            <input type="text" name="captcha" id="captcha" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</div>

      <footer>
        &copy; 2024 QuotesVally.com. All Rights Reserved. Made with ❤️ in India.
    </footer>

    <!-- JavaScript to handle modal functionality -->
    <script>
        function openModal() {
            document.getElementById("quoteModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("quoteModal").style.display = "none";
        }
    </script>
    
      <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
      <script>
        function downloadImage(id) {
          const container = document.getElementById(id);

          html2canvas(container).then(function(canvas) {
            const dataURL = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = dataURL;
            link.download = 'quotes-valley-image.png';
            link.click();
          });
        }
        
        function copyQuote(id){
            let quote =document.getElementById(id).innerText.replace('\n\n\n', ' - ');
            
            navigator.clipboard.writeText(quote);
        }
        
        addEventListener("DOMContentLoaded", (event) => {
            

            let classesArr = [
                'bg1',
                'bg2',
                'bg3',
                'bg4',
                'bg5',
                'bg6',
                'bg7',
                'bg8',
                'bg9',
                'bg10',
                'bg11',
                'bg12',
                'bg13',
                'bg14',
                'bg15',
                'bg16',
                'bg17',
                'bg18',
                'bg19',
                'bg20',
                'bg21',
                'bg22',
                'bg23',
                'bg24',
                'bg25',
                'bg26',
                'bg27',
                'bg28',
                'bg29',
                'bg30',
                'bg31',
                'bg32',
                'bg33',
                'bg34',
                'bg35',
                'bg36',
                'bg37',
                'bg38',
                'bg39',
                'bg40',
            ];
            (function () {
                
                
                // Get all elements with class name 'my-element'
                let elements = document.getElementsByClassName('image-quote');
                let ramdomNumber ='';
                let randomClass = '';
                // Loop through each element
                for (let i = 0; i < elements.length; i++) {
                    ramdomNumber = (Math.floor(Math.random() * 40));
                    randomClass = 
                        classesArr[ramdomNumber];
                      // Add new class name 'new-class' to each element
                    elements[i].classList.add(randomClass);
                }
                document.body.classList.add(classesArr[(Math.floor(Math.random() * 40))]);
            })();
            
        });
        
        // Get all elements with the 'myButton' class
        var buttons = document.querySelectorAll('.btn');
        
        // Loop through each button and add a click event listener
        buttons.forEach(function(button) {
          button.addEventListener('click', function() {
            // Toggle the 'clicked' class when the button is clicked
            button.classList.toggle('clicked');
          });
        });
      </script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
