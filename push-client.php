<html>
    <header>
        <title>RealTime Testing</title>
        <script src="autobahn.min.js"></script>
        <script>
		myVar = null;
		conn = null;
		function listen_socket(){
			if ( conn != null ) {
				conn.close();
			}
			conn = new ab.Session('ws://192.168.31.103:8080',
                function() {
					
					test();
					document.getElementById('rs').innerHTML += '</br>WELCOME</br>';
					
					//conn.onclose = setInterval('try_connect()', 3000);

					
                    conn.subscribe('kittensCategory', function(topic, data) {
                        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                        console.log('New article published to category "' + topic + '" : ' + data.title);
                        document.getElementById('rs').innerHTML += data.title;
                    });
                },
                function() {
                    console.warn('WebSocket connection closed');
					 clearInterval(myVar);
					 myVar = null;
					myVar = setInterval('try_connect()', 3000);
					
                },
                {'skipSubprotocolCheck': true}
            );
			
			
			
		}
		
		function test(){
			 clearInterval(myVar);
			 myVar = null;
		}
		
		function try_connect () {
			document.getElementById('rs').innerHTML += 'try to connect after 3 seconds </br>';
			listen_socket();
		}
		
        window.onLoad =  listen_socket();
        </script>
    </header>
    
    <body>
        <div id = 'rs'>
            
        </div>
    </body>
</html>