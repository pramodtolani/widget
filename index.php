<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test widget</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
</head>

<body>
  <div id="root"></div>
  <script>
    let latestJQ;

    function loadScript(url, cb) {
      try {
        var script = document.createElement("script")
        script.type = "text/javascript";


        if (script.readyState) { //IE
          script.onreadystatechange = function() {
            if (script.readyState == "loaded" || script.readyState == "complete") {
              script.onreadystatechange = null;
              cb();
            }
          };
        } else { //Others
          script.onload = function() {
            if (!window.jQuery) {
              console.log("jQuery not loaded.");
            } else {
              latestJQ = window.jQuery.noConflict(true);
              cb();
            }
          };
        }

        script.onerror = function(err) {
          console.log("jQuery not loaded.");
        };

        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
      } catch (err) {
        throw err;
      }
    }

    function bootstrap() {
      fetch("form.txt").then(res => res.text()).then(res => {
        document.getElementById("root").innerHTML = res;
        latestJQ(document).on("submit", "#widgetFrm", function(e) {
          e.preventDefault();
          let data = {
            body: latestJQ("#exampleInputSalary").val(),
            title: latestJQ("#exampleInputName").val(),
            // salary: jQuery(document, "#exampleInputSalary").val(),
          };
          latestJQ.ajax({
            url: "https://jsonplaceholder.typicode.com/posts",
            type: "post",
            data,
            // dataType: "application/json",
            success: function() {
              alert("form submitted");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              alert("Something went wrong.");
            }
          });
        })
      }).catch(err => console.log("err: ", err));
    }

    window.onload = _ => {
      loadScript('https://code.jquery.com/jquery-3.5.1.js', bootstrap);
    }
  </script>
</body>

</html>