const current = document.querySelector('#current');
const images = document.querySelectorAll('#images img');
const opacity = 0.4;

images.forEach(func);

function func (image) {
    image.addEventListener('click', imageClick);
}

function imageClick(next) {
    const current = document.querySelector('#current');
    const images = document.querySelectorAll('#images img');
    images.forEach(img => img.style.opacity = 1);
    current.src = next.target.src;
    next.target.style.opacity = opacity;

    makeRequest('amount_of_likes', 'update_likes.php', 'form1');
    setTimeout(function() { makeRequest('picture-by', 'update_author.php', 'form1'); }, 40);
    setTimeout(function() { makeRequest('comments_texts', 'update_comments.php', 'comments_form'); }, 70);
}

function makeRequest(divID, script, form) {
    document.getElementById('photo_id').value = current.src;
    document.getElementById('pic_id').value = current.src;
    var fd = new FormData(document.forms[form]);
    if (window.XMLHttpRequest)
            httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { 
            alertContents(httpRequest, divID);
        };
        httpRequest.open('POST', script, true);
        httpRequest.send(fd);
    }

function alertContents(httpRequest, divID) {
    if (httpRequest.readyState == 4) {
        if (httpRequest.status == 200) {
            document.getElementById(divID).innerHTML = httpRequest.responseText;
        } else {
            alert('There was a problem with the request. '+ httpRequest.status);
        }
    }
}