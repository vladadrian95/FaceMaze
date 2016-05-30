/* Engine.js
 * This file provides the game loop functionality (update entities and render),
 * draws the initial game board on the screen, and then calls the update and
 * render methods on your player and enemy objects (defined in app.js).
 * Also it uses AJAX requests to retrive data from the server
 * The labyrinth is a 33x33 matrix
 */

var Engine = (function(global) {
    
    var doc = global.document,
        win = global.window,
        canvas = doc.createElement('canvas'),
        ctx = canvas.getContext('2d'),
        lastTime,
        labyrinthMatrix = null,
        bestScore, 
        lastScore;

    canvas.width = 1056; //32px * 33
    canvas.height = 1056; //32px * 33

    var ratioWidth = 1.8181; // 1920/1056
    var ratioHeight = 1.0227; // 1080/1056

    OnResizeCalled();

    doc.body.appendChild(canvas);

    /* Add event listener for window resize to obtain a responsive design for the game canvas */
    window.addEventListener("resize", OnResizeCalled, false);

    /* Handles what happens with the canvas when the screen is resized */
    function OnResizeCalled() {
        var gameWidth = window.innerWidth;
        var gameHeight = window.innerHeight;
        canvas.style.width = gameWidth/ratioWidth + "px";
        canvas.style.height = gameHeight/ratioHeight + "px";
    }

    /* This function does some initial setup that should only occur once,
     * particularly setting the lastTime variable that is required for the
     * game
     */
    function init() {
        requestLabyrinth();
        reset();
        lastTime = Date.now();
        main();
    }

    /* AJAX requests to the server (get a random labyrinth matrix) */
    function requestLabyrinth() {
        var httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            console.log('Can not create XMLHttpRequest object');
        }
        httpRequest.onreadystatechange = function() {
            try {
                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                  if (httpRequest.status === 200) {
                    labyrinthMatrix = JSON.parse(httpRequest.responseText);
                    render(); //use render() as callback method
                  } else {
                    console.log('There was a problem with the request');
                  }
                }
            } catch( e ) {
                console.log('Caught Exception: ' + e.description);
            }
        }
        httpRequest.open('GET', 'http://localhost/FaceMaze/index.php/Main_Controller/start_game', true);
        httpRequest.send(null);
    }

    function main() {
        /* Get our time delta information which is required for
         * smooth animation
         */
        var now = Date.now(),
            dt = (now - lastTime) / 1000.0;

        /* Call our update/render functions, pass along the time delta to
         * our update function since it may be used for smooth animation.
         */
        if (labyrinthMatrix !== null) {
            update(dt);
            render();
        }

        /* Set our lastTime variable which is used to determine the time delta
         * for the next time this function is called.
         */
        lastTime = now;

        /* Use the browser's requestAnimationFrame function to call this
         * function again as soon as the browser is able to draw another frame.
         */
        win.requestAnimationFrame(main);
    }

    function update(dt) {
        //updateEntities(dt);
    }

    /* Update all the enemies and the player
     */
    function updateEntities(dt) {
        allEnemies.forEach(function(enemy) {
            enemy.update(dt);
        });
        player.update();
    }

    /* Renders the game
     * First it draws the labyrinth and then the entities
     * Called on each game tick
     */
    function render() {
        
        var rowImages = [
                'http://localhost/FaceMaze/images/free.png',
                'http://localhost/FaceMaze/images/wall.png'
            ],
            numRows = 33,
            numCols = 33,
            row, col;

        for (row = 0; row < numRows; row++) {
            for (col = 0; col < numCols; col++) {
                if (labyrinthMatrix[row].charAt(col) === '0')
                    ctx.drawImage(Resources.get(rowImages[0]), col * 32,row * 32);
                else
                    ctx.drawImage(Resources.get(rowImages[1]), col * 32, row * 32);
            }
        }

        //renderEntities();
    }

    function renderEntities() {
        allEnemies.forEach(function(enemy) {
            enemy.render();
        });

        player.render();
    }

    /* This function could be used to handle game resets
     * For now is empty
     */
    function reset() {
        var httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            console.log('Can not create XMLHttpRequest object');
        }
        httpRequest.onreadystatechange = function() {
            try {
                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                  if (httpRequest.status === 200) {
                    var scores = JSON.parse(httpRequest.responseText);
                    bestScore = scores[0];
                    lastScore = scores[1];
                    document.getElementById("best_score").innerHTML = "Best score is " + bestScore;
                    document.getElementById("last_score").innerHTML = "Last score is " + lastScore;
                  } else {
                    console.log('There was a problem with the request');
                  }
                }
            } catch( e ) {
                console.log('Caught Exception: ' + e.description);
            }
        }
        httpRequest.open('GET', 'http://localhost/FaceMaze/index.php/Main_Controller/get_score', true);
        httpRequest.send(null);
    }

    /* Load all the images that the game needs and
     * use init() as a callback method to start the
     * game
     */
    Resources.load([
        'http://localhost/FaceMaze/images/free.png',
        'http://localhost/FaceMaze/images/wall.png',
        'http://localhost/FaceMaze/images/pacman.png'
    ]);
    Resources.onReady(init)

    /* Assign the canvas' context object to the global variable (the window
     * object when run in a browser)
     */
    global.ctx = ctx;
})(this);
