function flipCoin() {
    // Randomly determine the result (heads or tails)
    var result = Math.random() < 0.5 ? 'heads' : 'tails';

    // Rotate the coin to simulate the flip
    var coinElement = document.getElementById('coin');
    coinElement.style.animation = 'rotate 0.5s ease-out';
    
    // After the animation, update the coin face and reset the rotation
    setTimeout(function() {
        coinElement.style.animation = '';
        coinElement.style.backgroundImage = result === 'heads' ? 'url("img-coinflip/munt.jpg")' : 'url("img-coinflip/kop.jpg")';
    }, 500);
}