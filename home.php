<?php  ?>

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

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Animated Background Fade-in */
body {
  background-image: url("bg.jpg");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color: white;
  line-height: 1.6;
  animation: fadeIn 1.5s ease-in-out;
}

/* Fade-in animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ===== HEADER (Modern Glass + Gradient) ===== */
header {
  background: linear-gradient(135deg, rgb(17, 164, 137), rgb(8, 108, 90));
  padding: 22px;
  text-align: center;
  font-size: 30px;
  font-weight: 700;
  letter-spacing: 1px;
  color: white;
  backdrop-filter: blur(5px);
  box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
  animation: slideDown 1s ease-out;
}

/* Header slide animation */
@keyframes slideDown {
  from { transform: translateY(-50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== TOP BAR ===== */
.top-bar {
  width: 100%;
  padding: 8px 25px;
  background: rgba(2, 136, 105, 0.9);
  text-align: right;
}

.login-btn {
  padding: 6px 16px;
  background: white;
  color: rgb(15, 196, 154);
  text-decoration: none;
  border-radius: 20px;
  font-size: 14px;
  font-weight: bold;
  transition: 0.3s;
}

.login-btn:hover {
  background: rgb(15, 196, 154);
  color: black;
}

/* ===== UPDATED NAVIGATION BAR (Modern Style) ===== */
nav {
  background: linear-gradient(90deg, rgb(17, 164, 137), rgb(17,164,137));
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0px 3px 8px rgba(0,0,0,0.3);
}

nav ul {
  list-style: none;
  display: flex;
  justify-content: center;
  padding: 5px 0;
}

nav ul li {
  margin: 0 8px;
}

nav ul li a {
  display: block;
  color: white;
  text-align: center;
  padding: 12px 22px;
  text-decoration: none;
  font-size: 18px;
  font-weight: bold;
  border-radius: 25px;
  transition: 0.3s ease-in-out;
}

/* Hover + Active Effect */
nav ul li a:hover {
  background: white;
  color: rgb(15, 196, 154);
  transform: scale(1.05);
}

/* ===== CONTENT BOX (Glassmorphism) ===== */
article {
  background: rgba(0, 0, 0, 0.6);
  margin: 30px auto;
  padding: 30px;
  width: 80%;
  border-radius: 12px;
  backdrop-filter: blur(5px);
  box-shadow: 0px 5px 15px rgba(0,0,0,0.4);
  animation: zoomIn 1s ease-in-out;
}

/* Content zoom animation */
@keyframes zoomIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

h2 {
  color: rgb(15, 196, 154);
  margin-bottom: 10px;
}

/* ===== BUTTON (Animated Glow) ===== */
.center-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

button {
  padding: 12px 45px;
  background: linear-gradient(135deg, #0ea539, #09e640);
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  box-shadow: 0px 0px 10px rgba(15,196,154,0.7);
}

button:hover {
  transform: scale(1.08);
  box-shadow: 0px 0px 20px rgba(15, 196, 154,0.7);
}

/* ===== FOOTER (Modern Gradient + Animation) ===== */
footer {
  background: linear-gradient(135deg, rgba(12, 161, 136, 0.95), rgba(12, 161, 136, 0.95));
  padding: 15px;
  text-align: center;
  color: white;
  margin-top: 30px;
  font-size: 18px;
  box-shadow: 0px -3px 8px rgba(0,0,0,0.3);
  animation: fadeUp 1s ease-in-out;
}

/* Footer animation */
@keyframes fadeUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 600px) {
  nav ul {
    flex-direction: column;
  }

  nav ul li {
    margin: 5px 0;
  }

  article {
    width: 95%;
  }
}




  </style>
</head>
<body>
     <header>
    <h1>
       FAKE NEW'S DETECTON SYSTEM
    </h1>
  </header>

  <div class="top-bar">
    <a href="login.php" class="login-btn">Login</a>
</div>

  <!-- Navigation bar -->
  <nav>
    <ul>
      <li><a href="home.php">HOME</a></li>
      <li><a href="register.php">REGISTER</a></li>
      <li><a href="news.php">DETECT NEWS</a></li>
    </ul>
  </nav>

  <article>
    <h2>INTRODUCTION</h2>
    <p>
        A Fake News Detection System is designed to automatically analyze news content and determine whether 
        the information is real or fake. The system uses machine learning and natural language processing (NLP) 
        techniques to examine textual patterns, word usage, and contextual meaning in news articles. By learning 
        from previously labeled datasets, the model can accurately classify news based on its authenticity.</p>
<p>
The proposed system allows users to input news text through a simple interface, after which the system
 processes the content and displays the detection result. This automated approach reduces manual effort,
  improves accuracy, and provides quick results. The Fake News Detection System can be effectively used
   in media organizations, educational institutions, and online platforms to promote reliable information sharing and reduce misinformation.
    </p><br>
   <center> <img src="fake4.webp" height="250" width="400"></center>

<h2>WHAT IS FAKE NEW'S?</h2>
<p>
    Fake news refers to false, misleading, or fabricated information presented as real news with the intention of deceiving people. 
    It is deliberately created to influence public opinion, gain political advantage, or generate financial profit through increased 
    views and shares. Fake news often appears on social media platforms, websites, and messaging apps, making it difficult for users 
    to distinguish between genuine and false information.</p>
<p>
Fake news may include completely false stories, manipulated facts, misleading headlines, or out-of-context information.
 It commonly uses emotional language, sensational headlines, and unverified sources to attract attention and spread rapidly. 
 Due to the fast circulation of digital content and lack of verification, fake news has become a major challenge in today’s information-driven society.
</p><br>
<center><img src="news.webp" height="250" width="400"></center><br>

<h2>WHY NEW'S DETECTION IS IMPORTANT?</h2>
<P>
    News detection is important in today’s digital age because false and misleading information spreads very quickly
     through online platforms and social media. Fake news can confuse people, influence their opinions, and lead to wrong decisions.
      By identifying and filtering false information, news detection systems help ensure that users receive accurate and trustworthy 
      content. This is essential for protecting public opinion and maintaining trust in information sources.
</P>
<P>
Moreover, fake news can cause serious social, political, and economic problems. It may create panic, social unrest, hatred, or
 misunderstandings among communities. In political contexts, fake news can manipulate voters and affect democratic processes.
  News detection systems help reduce these risks by identifying unverified or fabricated content before it spreads widely. 
  This supports credible journalism and promotes responsible information sharing.
</P>
<P>
Additionally, automated news detection saves time and effort compared to manual fact-checking.
 It provides quick results and improves awareness about misinformation among users. By preventing the spread of false information,
  news detection systems help build a safer digital environment and strengthen public confidence in online news platforms.
</P><br>

    <h2>CAUSES OF FAKE NEW'S</h2><br>
        <h4>1. Social Media Influence</h4>
<p>
Social media platforms allow anyone to share information instantly without verification. False news spreads rapidly through likes, shares, and forwards, often faster than real news.
</p>
<h4>2. Lack of Verification</h4>
<p>
Many users share news without checking the authenticity of the source. The absence of fact-checking leads to the circulation of misleading or completely false information.
</p>
<h4>3. Political and Ideological Agendas</h4>
<p>
Fake news is often created to influence political opinions, elections, or public beliefs. Biased or manipulated information is spread to support specific ideologies.
</p>
<h4>4. Financial Benefits</h4>
<p>
Some individuals and organizations generate fake news to attract clicks, increase website traffic, and earn money through advertisements, a practice known as clickbait.
</p>
<h4>
5. Low Digital Literacy</h4>
<p>
People with limited knowledge of digital media are more likely to believe and share fake news, making misinformation easier to spread.
</p>
<h4>6. Emotional Content</h4>
<p>
Fake news often uses exaggerated or emotional language to attract attention. Content that triggers fear, anger, or excitement spreads more quickly.
</p>
<h4>7. Absence of Strict Regulations</h4>
<p>
Weak legal actions and lack of strict monitoring allow fake news creators to operate freely without facing serious consequences.
</p>
<h4>8. Automated Bots and Fake Accounts</h4>
<p>
Bots and fake social media accounts are used to mass-produce and distribute fake news, increasing its reach and impact.
</p>
<h4>9. Time Pressure in News Reporting</h4>
<p>
In the race to be the first to publish news, accuracy is sometimes compromised, leading to the spread of unverified or false information.
</p>
<h4>10. Misuse of Technology</h4>
<p>
Advanced tools like AI-generated content, deepfakes, and manipulated images/videos contribute to the creation of realistic but false news.
    </p><br><br>

  </article>
</body>
<footer>
  BE AWARE OF FAKE NEW'S
</footer>
</html>