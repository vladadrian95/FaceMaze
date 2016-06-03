//labyrinth object
var Labyrinth = function() {
 this.matrix = null;
}

Labyrinth.prototype.loadMatrix = function(newMatrix) {
 this.matrix = newMatrix;
}

Labyrinth.prototype.getValue = function(x, y) {
 return this.matrix[y].charAt(x);
}

var labyrinth = new Labyrinth();

//the player object
var Player = function() {
    this.sprite = 'http://localhost/FaceMaze/images/pacman.png'
    this.x = 512;//[512][608] d=2   for (...speed*dt (512+32,608))
    this.y = 608;
    this.score = 0;
    this.speed=32;
    this.direction=-1;
    this.futureDirection = -1;
};

var isWallAt  =   function(x,y,direction){
    if (direction===0){
        if (labyrinth.getValue( (x/32), ((y-32)/32)) === '1')
            return true;
        else return false;
        }
    else if (direction===1){
        if (labyrinth.getValue( (x/32), ((y+32)/32)) === '1')
            return true;
        else return false;
        } 
    else if (direction===2){
        if (labyrinth.getValue( ((x+32)/32), (y/32)) === '1')
            return true;
        else return false;
        }
    else if (direction===3){
        if (labyrinth.getValue( ((x-32)/32), (y/32)) === '1')
            return true;
        else return false;
        }
    return true ;
}

//update player's move
Player.prototype.update = function(dt) {
    //this.x = this.x + this.speed*dt;

    if (this.x%32===0&&this.y%32===0){
        if (this.direction === 0 && isWallAt(this.x,this.y,0))//Player moves north
            this.direction=-1;
        else if (this.direction === 1 &&isWallAt(this.x,this.y,1))//Player moves south
            this.direction=-1;
        else if (this.direction === 2 &&isWallAt(this.x,this.y,2))//played moves east
            this.direction=-1;
        else if (this.direction === 3 &&isWallAt(this.x,this.y,3))//player moves west
            this.direction=-1;
        if (this.futureDirection === 0 && !isWallAt(this.x,this.y,0))//Player moves north
            this.direction=this.futureDirection;
        else if (this.futureDirection === 1 &&!isWallAt(this.x,this.y,1))//Player moves south
            this.direction=this.futureDirection;
        else if (this.futureDirection === 2 &&!isWallAt(this.x,this.y,2))//played moves east
            this.direction=this.futureDirection;
        else if (this.futureDirection === 3 &&!isWallAt(this.x,this.y,3))//player moves west
            this.direction=this.futureDirection;
    }

    if (this.direction === 0 )//Player moves north
        this.y = this.y-2;

    else if (this.direction === 1 )//Player moves south
        this.y=this.y+2;
    else if (this.direction === 2 )//played moves east
        this.x=this.x+2;
    else if (this.direction === 3 )//player moves west
        this.x=this.x-2    ;
};

//draw the player
Player.prototype.render = function() {
    ctx.drawImage(Resources.get(this.sprite), this.x, this.y);
};

//handle user's input for player movement
Player.prototype.handleInput = function(input_key) {
    if (input_key === 'left')
        this.futureDirection=3;
    if (input_key === 'up')
        this.futureDirection=0;
    if (input_key === 'right')
        this.futureDirection=2;
    if (input_key === 'down')
        this.futureDirection=1;
};

// Place the player object in a variable called player
var player = new Player();

// This listens for key presses and sends the keys to handleInput method
document.addEventListener('keyup', function(e) {
    var allowedKeys = {
        37: 'left',
        38: 'up',
        39: 'right',
        40: 'down'
    };

    player.handleInput(allowedKeys[e.keyCode]);
});