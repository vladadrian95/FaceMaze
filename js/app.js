
var isGameFinished = false;

//labyrinth object
var Labyrinth = function() {
 this.matrix = null;
};

Labyrinth.prototype.loadMatrix = function(newMatrix) {
 this.matrix = newMatrix;
};

Labyrinth.prototype.getValue = function(x, y) {
 return this.matrix[y].charAt(x);
};

var labyrinth = new Labyrinth();

var Ball = function(x,y){
    this.sprite = 'http://localhost/FaceMaze/images/ball.png';
    this.x=x;
    this.y=y;
    this.exists=true;
};

Ball.prototype.render = function() {
    if (this.exists === true)    
        ctx.drawImage(Resources.get(this.sprite), this.x, this.y);
};

var Balls = function(){
    this.matrix= null;
    this.ballsArray = [];
};

Balls.prototype.setMatrix = function(newMatrix) {
    this.matrix = newMatrix;
    for (var i = 0;i < 33; i++)
        for (var j = 0; j < 33; j++)
            if (this.matrix[i][j]==='0')
                this.ballsArray.push(new Ball(j*32,i*32));

}

Balls.prototype.getStatus = function(x, y) {
    return this.matrix[y].charAt(x);
}

Balls.prototype.setStatus = function(x, y) {
    this.matrix[y] = this.matrix[y].substr(0, x) + '2' + this.matrix[y].substr(x + 1);
    this.ballsArray = [];
    for (var i = 0;i < 33; i++)
        for (var j = 0; j < 33; j++)
            if (this.matrix[i][j]==='0')
                this.ballsArray.push(new Ball(j*32,i*32));
}

var balls = new Balls();

var Enemy = function() {
    this.sprite = 'http://localhost/FaceMaze/images/ghost.png';
    this.x = 512;
    this.y = 512;
    this.direction=0;
};


var getPossibleDirections = function(x,y){
    var dir = [0,0,0,0];
    if (!isWallAt(x,y,0))
        dir[0]=1;
    if (!isWallAt(x,y,1))
        dir[1]=1;
    if (!isWallAt(x,y,2))
        dir[2]=1;
    if (!isWallAt(x,y,3))
        dir[3]=1;
    return dir;
};

var getRandomDirection = function(x,y){
    var dir;
    var direction;
    dir=getPossibleDirections(x,y);
    do{
        direction=Math.floor(Math.random()*4);
    }while (dir[direction]!=1);
    return direction;
};

var getCountPossibleDirections = function(x,y){
    var count=0;
    var dir=getPossibleDirections(x,y);
    for (var i=0;i<4;i++)
        count=count+dir[i];
    return count;
};




// Update the enemy's position, required method for game
// Parameter: dt, a time delta between ticks
Enemy.prototype.update = function(dt) {
    
    if (this.x%32===0&&this.y%32===0){
        if (this.direction === 0 && isWallAt(this.x,this.y,0))//Player moves north
            this.direction=getRandomDirection(this.x,this.y);
        else if (this.direction === 1 &&isWallAt(this.x,this.y,1))//Player moves south
            this.direction=getRandomDirection(this.x,this.y);//getRandomDirection(this.x,this.y);
        else if (this.direction === 2 &&isWallAt(this.x,this.y,2))//played moves east
            this.direction=getRandomDirection(this.x,this.y);//getRandomDirection(this.x,this.y);
        else if (this.direction === 3 &&isWallAt(this.x,this.y,3))//player moves west
            this.direction=getRandomDirection(this.x,this.y);//getRandomDirection(this.x,this.y);
        else if (this.direction === 0 && !isWallAt(this.x,this.y,0)
                    &&getCountPossibleDirections(this.x,this.y)>2)//Player moves north
            this.direction=getRandomDirection(this.x,this.y);
        else if (this.direction === 1 && !isWallAt(this.x,this.y,1)
                    &&getCountPossibleDirections(this.x,this.y)>2)//Player moves south
            this.direction=getRandomDirection(this.x,this.y);
        else if (this.direction === 2 && !isWallAt(this.x,this.y,2)
                    &&getCountPossibleDirections(this.x,this.y)>2)//played moves east
            this.direction=getRandomDirection(this.x,this.y);
        else if (this.direction === 3 && !isWallAt(this.x,this.y,3)
                    &&getCountPossibleDirections(this.x,this.y)>2)//player moves west
            this.direction=getRandomDirection(this.x,this.y);
    }
     //collision
        if (((player.x-16)<(this.x))&&((this.x)<(player.x+16))&&
            ((player.y-16)<(this.y))&&((this.y)<(player.y+16))) {
                alert("Game over!");
                isGameFinished = true;

        }
    if (this.direction === 0 )//Player moves north
        this.y = this.y-4;
    else if (this.direction === 1 )//Player moves south
        this.y=this.y+4;
    else if (this.direction === 2 )//played moves east
        this.x=this.x+4;
    else if (this.direction === 3 )//player moves west
        this.x=this.x-4;
};

//draw the enemy
Enemy.prototype.render = function() {
    ctx.drawImage(Resources.get(this.sprite), this.x, this.y);
};

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
};

//update player's move
Player.prototype.update = function(dt) {
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
        //score
        if (balls.getStatus(this.x/32,this.y/32)==='0'){
            this.score=this.score+10;
            balls.setStatus(this.x/32,this.y/32);
            //labyrinth.setValue(this.x/32,this.y/32);
           // renderFree(this.x,this.y);
        }
        if (balls.ballsArray.length < 300) {
            alert("You won!");
            isGameFinished = true;
        }
    }
    if (this.direction === 0 )//Player moves north
        this.y = this.y-4;

    else if (this.direction === 1 )//Player moves south
        this.y=this.y+4;
    else if (this.direction === 2 )//played moves east
        this.x=this.x+4;
    else if (this.direction === 3 )//player moves west
        this.x=this.x-4;
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


// Place all enemy objects in an array called allEnemies
// Place the player object in a variable called player

var player = new Player();
var allEnemies = [new Enemy(), new Enemy(), new Enemy(), new Enemy(),new Enemy(),new Enemy()];

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

var resetObjects = function() {
    isGameFinished = false;
    labyrinth = new Labyrinth();
    balls = new Balls();
    player = new Player();
    allEnemies = [new Enemy(), new Enemy(), new Enemy(), new Enemy(),new Enemy(),new Enemy()];
}