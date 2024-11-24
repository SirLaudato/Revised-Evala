<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="/css/global.css" />
        <link rel="stylesheet" href="/css/evaluation.css" />
        <link rel="stylesheet" href="/components/all.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="questionnaire">
            <div class="navigator">
                <?php include('C:\Users\Lawrence\Documents\Revised Evala\components\nav.php') ?>
            </div>

            <div class="frame-2">
                <div class="frame-wrapper">
                    <div class="frame-3">
                        <div class="text-wrapper-3">Evaluation Name</div>
                        <p class="p">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                        </p>
                    </div>
                    <div class="frame-3">
                        <ol>
                            <li><strong>1 - Strongly Disagree</strong></li>
                            <li><strong>2 - Disagree</strong></li>
                            <li><strong>3 - Neutral</strong></li>
                            <li><strong>4 - Agree</strong></li>
                            <li><strong>5 - Strongly Agree</strong></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="questionnaire-evaluation">
            <div class="frame-wrapper">

                    <!-- Section name for example: Curriculum Objectives -->
                    <!-- Section desc for example: In this section, ... -->
                </div>

                    <form action="/submit-evaluation" method="POST">
                        <div class="per-section">
                                    <div class="frame-3">
                                        <div class="text-wrapper-3">Section Name</div>
                                            <p class="p">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                                            </p>
                                                <div id="progress-modal">
                                                    <div class="progress-text"><span id="progress-percentage">0%</span></div>
                                                    <div id="progress-bar">
                                                    <div style="width: 0%"></div>
                                                    </div>
                                                </div>

                                        </div>
                            <div class="questionnaire-per-section">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>1<br></th>
                                            <th>2<br></th>
                                            <th>3<br></th>
                                            <th>4<br></th>
                                            <th>5<br></th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <td class="question">1. The quality of the product met my expectations.</td>
                                            <td><input type="radio" name="q1" value="1" required></td>
                                            <td><input type="radio" name="q1" value="2"></td>
                                            <td><input type="radio" name="q1" value="3"></td>
                                            <td><input type="radio" name="q1" value="4"></td>
                                            <td><input type="radio" name="q1" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">2. The customer service experience was satisfactory.</td>
                                            <td><input type="radio" name="q2" value="1" required></td>
                                            <td><input type="radio" name="q2" value="2"></td>
                                            <td><input type="radio" name="q2" value="3"></td>
                                            <td><input type="radio" name="q2" value="4"></td>
                                            <td><input type="radio" name="q2" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">3. The delivery process was efficient and timely.</td>
                                            <td><input type="radio" name="q3" value="1" required></td>
                                            <td><input type="radio" name="q3" value="2"></td>
                                            <td><input type="radio" name="q3" value="3"></td>
                                            <td><input type="radio" name="q3" value="4"></td>
                                            <td><input type="radio" name="q3" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">4. Overall, I am satisfied with my experience.</td>
                                            <td><input type="radio" name="q4" value="1" required></td>
                                            <td><input type="radio" name="q4" value="2"></td>
                                            <td><input type="radio" name="q4" value="3"></td>
                                            <td><input type="radio" name="q4" value="4"></td>
                                            <td><input type="radio" name="q4" value="5"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="per-section">
                                    <div class="frame-3">
                                        <div class="text-wrapper-3">Section Name</div>
                                            <p class="p">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                                            </p>
                                        </div>
                            <div class="questionnaire-per-section">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>1<br></th>
                                            <th>2<br></th>
                                            <th>3<br></th>
                                            <th>4<br></th>
                                            <th>5<br></th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <td class="question">1. The quality of the product met my expectations.</td>
                                            <td><input type="radio" name="q5" value="1" required></td>
                                            <td><input type="radio" name="q5" value="2"></td>
                                            <td><input type="radio" name="q5" value="3"></td>
                                            <td><input type="radio" name="q5" value="4"></td>
                                            <td><input type="radio" name="q5" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">2. The customer service experience was satisfactory.</td>
                                            <td><input type="radio" name="q6" value="1" required></td>
                                            <td><input type="radio" name="q6" value="2"></td>
                                            <td><input type="radio" name="q6" value="3"></td>
                                            <td><input type="radio" name="q6" value="4"></td>
                                            <td><input type="radio" name="q6" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">3. The delivery process was efficient and timely.</td>
                                            <td><input type="radio" name="q7" value="1" required></td>
                                            <td><input type="radio" name="q7" value="2"></td>
                                            <td><input type="radio" name="q7" value="3"></td>
                                            <td><input type="radio" name="q7" value="4"></td>
                                            <td><input type="radio" name="q7" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">4. Overall, I am satisfied with my experience.</td>
                                            <td><input type="radio" name="q8" value="1" required></td>
                                            <td><input type="radio" name="q8" value="2"></td>
                                            <td><input type="radio" name="q8" value="3"></td>
                                            <td><input type="radio" name="q8" value="4"></td>
                                            <td><input type="radio" name="q8" value="5"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="per-section">
                                    <div class="frame-3">
                                        <div class="text-wrapper-3">Section Name</div>
                                            <p class="p">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                                            </p>
                                        </div>
                            <div class="questionnaire-per-section">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>1<br></th>
                                            <th>2<br></th>
                                            <th>3<br></th>
                                            <th>4<br></th>
                                            <th>5<br></th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <td class="question">1. The quality of the product met my expectations.</td>
                                            <td><input type="radio" name="q9" value="1" required></td>
                                            <td><input type="radio" name="q9" value="2"></td>
                                            <td><input type="radio" name="q9" value="3"></td>
                                            <td><input type="radio" name="q9" value="4"></td>
                                            <td><input type="radio" name="q9" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">2. The customer service experience was satisfactory.</td>
                                            <td><input type="radio" name="q10" value="1" required></td>
                                            <td><input type="radio" name="q10" value="2"></td>
                                            <td><input type="radio" name="q10" value="3"></td>
                                            <td><input type="radio" name="q10" value="4"></td>
                                            <td><input type="radio" name="q10" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">3. The delivery process was efficient and timely.</td>
                                            <td><input type="radio" name="q11" value="1" required></td>
                                            <td><input type="radio" name="q11" value="2"></td>
                                            <td><input type="radio" name="q11" value="3"></td>
                                            <td><input type="radio" name="q11" value="4"></td>
                                            <td><input type="radio" name="q11" value="5"></td>
                                        </tr>
                                        <tr>
                                            <td class="question">4. Overall, I am satisfied with my experience.</td>
                                            <td><input type="radio" name="q12" value="1" required></td>
                                            <td><input type="radio" name="q12" value="2"></td>
                                            <td><input type="radio" name="q12" value="3"></td>
                                            <td><input type="radio" name="q12" value="4"></td>
                                            <td><input type="radio" name="q12" value="5"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            
                           <button type="submit" class="submit-btn" disabled>Submit Evaluation</button>
                            <button type="submit" class="cancel-btn">Cancel</button>
                                
                    </form>
            </div>

        <script>
            const totalQuestions = document.querySelectorAll('input[type="radio"][required]').length;
            const progressBar = document.querySelector('#progress-bar > div');
            const progressPercentage = document.getElementById('progress-percentage');
            const submitButton = document.querySelector('.submit-btn');

            function updateProgress() {
            const answeredQuestions = Array.from(
                document.querySelectorAll('input[type="radio"]:checked')
            ).filter(input => input.name.startsWith('q')).length;

            const progress = Math.round((answeredQuestions / totalQuestions) * 100);
            progressBar.style.width = `${progress}%`;
            progressPercentage.textContent = `${progress}%`;

            // Enable submit button if all questions are answered
            submitButton.disabled = answeredQuestions < totalQuestions;
            }

            // Attach event listeners to radio buttons
            const radios = document.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
            radio.addEventListener('change', updateProgress);
            });

            // Initialize progress
            updateProgress();
        </script>

        
            <?php include 'C:\Users\Lawrence\Documents\Revised Evala\components\footer.php' ?>
        </div>
    </body>
</html>
