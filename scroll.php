<!doctype html>
<html>
  <head>
    <title>Antiscroll - os x lion style cross-browser native scrolling on the web that gets out of the way</title>
    <link href="css/antiscroll.css" rel="stylesheet" />

    <style>
      body {
        padding: 80px 100px;
        font: 14px/1.4 'helvetica neue', helvetica, arial, sans-serif;
      }

      h1 {
        font-size: 28px;
      }

      .box {
        background: #eee;
      }

      .box, .box .antiscroll-inner {
        width: 250px;
        height: 250px;
        font: 14px Helvetica, Arial;
      }
      
      .box-wrap {
        margin: 20px 40px;
        border: 1px solid #999;
      }

      .box-inner {
        background: #eee;
        padding: 10px;
        color: #999;
        text-shadow: 0 1px 0 #fff;
      }

      .button {
        -webkit-user-select: none;
        display: block;
        background: #3b88d8;
        text-decoration: none;
        background: -o-linear-gradient(0% 100% 90deg, #377ad0, #52a8e8);
        background: -moz-linear-gradient(0% 100% 90deg, #377ad0, #52a8e8);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#52a8e8), to(#377ad0));
        border-top: 1px solid #4081af;
        border-right: 1px solid #2e69a3;
        border-bottom: 1px solid #20559a;
        border-left: 1px solid #2e69a3;
        -moz-border-radius: 16px;
        -webkit-border-radius: 16px;
        border-radius: 16px;
        -moz-box-shadow: inset 0 1px 0 0 #72b9eb, 0 1px 2px 0 #b3b3b3;
        -webkit-box-shadow: inset 0 1px 0 0 #72b9eb, 0 1px 2px 0 #b3b3b3;
        box-shadow: inset 0 1px 0 0 #72b9eb, 0 1px 2px 0 #b3b3b3;
        color: #fff;
        font-family: "lucida grande", sans-serif;
        font-size: 11px;
        font-weight: normal;
        line-height: 1;
        padding: 3px 0 5px 0;
        text-align: center;
        text-shadow: 0 -1px 1px #3275bc;
        width: 112px;
        -webkit-background-clip: padding-box;
      }

      .button:hover {
        background: #2a81d7;
        background: -o-linear-gradient(0% 100% 90deg, #206bcb, #3e9ee5);
        background: -moz-linear-gradient(0% 100% 90deg, #206bcb, #3e9ee5);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#3e9ee5), to(#206bcb));
        border-top: 1px solid #2a73a6;
        border-right: 1px solid #165899;
        border-bottom: 1px solid #07428f;
        border-left: 1px solid #165899;
        -moz-box-shadow: inset 0 1px 0 0 #62b1e9;
        -webkit-box-shadow: inset 0 1px 0 0 #62b1e9;
        cursor: pointer;
        text-shadow: 0 -1px 1px #1d62ab;
        -webkit-background-clip: padding-box;
        text-decoration: none;
      }

      .button:active {
        background: #3282d3;
        border: 1px solid #154c8c;
        border-bottom: 1px solid #0e408e;
        -moz-box-shadow: inset 0 0 6px 3px #1657b5, 0 1px 0 0 #fff;
        -webkit-box-shadow: inset 0 0 6px 3px #1657b5, 0 1px 0 0 #fff;
        box-shadow: inset 0 0 6px 3px #1657b5, 0 1px 0 0 #fff;
        text-shadow: 0 -1px 1px #2361a4;
        -webkit-background-clip: padding-box;
      }

      ul#features {
        margin: 40px 0;
        padding: 0 20px;
        float: left;
        width: 600px;
      }

      ul#features li {
        list-style: none;
      }

      ul {
        padding: 0 15px;
      }

      ul li {
        margin: 0 5px;
        padding: 3px 0;
      }

      .action {
        color: #0069d6;
        cursor: pointer;
      }

      .action:hover {
        color: #00438a;
      }

    </style>

    <script src="js/jquery-1.7.2.js"></script>
    <script src="js/jquery-mousewheel.js"></script>
    <script src="js/antiscroll.js"></script>

    <script>

      $(function () {
        scroller = $('.box-wrap').antiscroll().data('antiscroll');

        $("#addRow").click(function() {                    
          $('.box-wrap tr:last').clone().appendTo('.box-wrap table');
          $("#rows b").text($(".box-wrap tr").length);
          scroller.refresh();
        });

        $("#removeRow").click(function() {
          $('.box-wrap tr:last').remove();
          $("#rows b").text($(".box-wrap tr").length);
          scroller.refresh();
        });

        $("#addCol").click(function() {           
          $('.box-wrap tr').each(function(index, tr) {            
            $('td:last', tr).clone().appendTo(tr);
          });
          $("#cols b").text($(".box-wrap tr:last td").length);
          scroller.refresh();
        });

        $("#removeCol").click(function() {          
          $('.box-wrap tr').find('td:last').remove();
          $("#cols b").text($(".box-wrap tr:last td").length);
          scroller.refresh();
        });

        $("#rows b").text($(".box-wrap tr").length);
        $("#cols b").text($(".box-wrap tr:last td").length);        
      });



    </script>
  </head>
  <body>
    <div id="page">
      <h1>Antiscroll</h1>
      <p>os x lion style cross-browser native scrolling on the web that gets out of the way.</p>
      <ul id="features">
        <li>supports mousewheels, trackpads, other input devices natively.</li>
        <li>total size is <b>1kb</b> minified and gzipped.</li>
        <li>doesn't magically autowrap your elements with divs (manual wrapping is necessary, please see index.html demo).</li>
        <li>fade in/out controlled with CSS3 animations.</li>
        <li>shows scrollbars upon hovering.</li>
        <li>scrollbars are draggable.</li>
        <li>size of container can be dynamically adjusted and scrollbars will adapt.</li>
        <li>supports IE7+, Firefox 3+, Chrome, Safari, Opera</li>
      </ul>
      <div class="box-wrap antiscroll-wrap">
        <div class="box">
          <div class="antiscroll-inner">
            <div class="box-inner">
              <table>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
                <tr>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                  <td>Body</td><td>Body</td><td>Body</td><td>Body</td><td>Body</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <br style="clear: both">
      <a href="https://github.com/learnboost/antiscroll/downloads" class="button">Download</a>

      <br /> 
      
      <p id="rows"><b>X</b> rows</p>  
      <ul>
        <li><a class="action" id="addRow" >Add row</a></li>
        <li><a class="action" id="removeRow">Remove row</a></li>
      </ul>

      <p id="cols"><b>X</b> cols</p>
      </ul>
        <li><a class="action" id="addCol" >Add col</a></li>
        <li><a class="action" id="removeCol">Remove col</a></li>
      </ul>
    
    </div>
  </body>
</html>
