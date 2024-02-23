export default function uploadFile(){

    window.addEventListener('load', function() {
        const inputFile =  document.querySelector('input[type="file"]');
        if(inputFile){
            inputFile.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    var img = document.querySelector('.loading-img img');
                    img.onload = () => {
                        URL.revokeObjectURL(img.src);  // no longer needed, free memory
                    }
                    img.style.display = 'flex';
                    document.querySelector('.preview-img').style.display = 'none'
                    img.src = URL.createObjectURL(this.files[0]); // set src to blob url
                }
            });
        }
    });
}