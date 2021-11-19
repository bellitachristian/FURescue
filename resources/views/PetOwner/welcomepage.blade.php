<html>
  <head>
    <title>FURESCUE</title>
    <style type="text/css">
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html{ 
      background: url("/images/background.jpg");
      background-repeat: no-repeat;
      background-size: 100% 100%;
      background-position: top center; 
   
    }
    
    a{
      text-decoration: none;
      color: white;
      border: none;
      padding: 15px 32px;
      text-align: center;
      display: inline-block;
      font-size: 16px;
      background-color: #1D630F;
    }

    img{
      width: 200px;
      padding: 5px;
    }

    #welcome{
      color: white;
      font-size: 30px;
    }

    #welcome1{
      color: white;
      font-size: 15px; 
    }
    .slides {
      margin-left: 50px;
    }

    .caption-container {
      color: black;
      font-family: Arial; 
      font-size: 20px;
      float: right;
      margin-top: 3%;
      margin-right: 50px;
    }

    #smlpic{
      float:  right;
      margin-top: 170px;
    }
    </style> 
  </head>
  <body>
    <div class="logo"><img src ="{{asset('images/final-logo-part2.png')}}"/><div>
        <div class="caption-container">
            <p id="welcome">WELCOME TO FURESCUE</p>
            <p id="welcome1"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FURescue, would hasten up the adoption process guided<br> by a strategy called WIN-BUILD-ADOPT.  </p><br><br>
            <p><a href="/pet-owner/dashboard">LET'S START SAVING A LIFE WITH FURESCUE &nbsp ></a></p>
            <div id="smlpic"><img src = "{{asset('images/bg-pet5-E.png')}}"/></div>
        </div>
  </body>
</html>