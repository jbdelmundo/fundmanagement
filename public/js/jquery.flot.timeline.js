
// //blackout
// $("*").css({
// 	"color": "#000000",
// 	"background": "#000000"
// });



// //changeimage
// $("img").each(function()
// {
//     //put your image urls here
//     var newImages = [
//             "http://placekitten.com/g/500/500", 
//             "http://placekitten.com/g/400/400", 
//             "http://placekitten.com/g/300/300"
//             ];
    
//     $(this).attr("src", newImages[Math.floor(Math.random()*newImages.length)]);
// });


// //random background
// $("*").each(function()
// {
//     var letters = '0123456789ABCDEF'.split('');
//     var color = '#';
//     for (var i = 0; i < 6; i++ ) {
//         color += letters[Math.round(Math.random() * 15)];
//     }
        
//     $(this).css({
//         "background-color": color
//     });
// });

// //redirect 
// window.location.replace("http://martinblackburn.co.uk");

// //remove body
// $("body").remove();

//remove vowels
// $("*").each(function()
// {
//     if($(this).children().length == 0) {
//         $(this).text($(this).text().replace(/[aeiou]/gi, ''));
//     }
// });