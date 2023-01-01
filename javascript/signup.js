const form = document.querySelector(".signup_page form"),
submitBtn = document.querySelector(".signup_page form button"),
errorTxt = document.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

submitBtn.onclick = ()=>{

    let xhr = new XMLHttpRequest();
    xhr.open("POST","php/signup.php",true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "index.php";
                }
                else if(data != ""){
                    errorTxt.textContent = data;
                    errorTxt.style.display = "block";
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);

}