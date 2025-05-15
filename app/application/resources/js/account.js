/**
 * Scripts para pagina de conta do cliente
 */
export function init(){
    // document.querySelector("#account").addEventListener("click", function () {
    //     async function loadPage() {
    //         try{
    //             const response = await fetch('/account', {
    //                 method: 'GET',
    //                 headers: {
    //                     'Content-Type': 'application/json',
    //                     'XSRF-TOKEN': sessionStorage.getItem('XSRF-TOKEN')
    //                 },
    //                 credentials: 'include'                    
    //             });

    //             const data = await response.text();
    //             document.querySelector("#app-content").innerHTML = data;
                
    //         } catch (error) {
    //             console.log(error);
    //         }
    //     }

    //     loadPage();
    // });

    document.querySelector("#app-content").addEventListener("click", function (e) {        
        if(e.target.closest(".switch-eye")){
            const icon = e.target.closest(".switch-eye").querySelector("i");
            const pwdText = e.target.closest(".switch-eye").previousElementSibling;
            if(icon.classList.contains("heroicon-eye-slash")){
                icon.classList.remove("heroicon-eye-slash");
                icon.classList.add("heroicon-eye");
                pwdText.type = "text";
            } else {
                icon.classList.remove("heroicon-eye");
                icon.classList.add("heroicon-eye-slash");
                pwdText.type = "password";
            }
        }
    });
}