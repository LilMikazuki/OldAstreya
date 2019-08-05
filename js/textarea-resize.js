let textarea = document.querySelectorAll('textarea');

for (let i = 0; i < textarea.length; i++) {
    textarea[i].addEventListener('keyup', function(){
        if (this.scrollTop > 0 && this.scrollHeight < 250)
            this.style.height = this.scrollHeight + "px";
        else {
            if (this.value === '')
                this.style.height = 25 + 'px';
        }
    });
}

