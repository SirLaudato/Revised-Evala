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
                        <div class="text-wrapper-3">Privacy Setting</div>
                        <p class="p">
                        At Innovatio, we prioritize your privacy and are committed to ensuring a secure and trustworthy evaluation process. Your feedback is invaluable, and we take every measure to protect your personal information. 
                        Explore the Innovatio Privacy Policy to understand how we handle, use, and safeguard your data throughout the evaluation journey.
                        </p>
                    </div>
                    <div class="frame-3">
                        <p class="p">
                            Please read each question carefully and choose the option that best represents your perspective. Your feedback is essential in shaping and improving the curriculum.
                        </p>
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
                    <div class="frame-3">
                        <div class="text-wrapper-3">Section Name</div>
                        <p class="p">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                        </p>
                    </div>
                </div>

                        <form action="/submit-evaluation" method="POST">
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
                    <button type="submit" class="submit-btn">Submit Evaluation</button>
                </form>
            </div>

<?php include 'C:\Users\Lawrence\Documents\Revised Evala\components\footer.php' ?>
        </div>
    </body>
</html>
