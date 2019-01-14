export const getImageBase64Code=(file)=>{
    return new Promise((resolve,reject) => {
        let reader = new FileReader();
        reader.addEventListener("load", function () {
            if (file.type === 'image/jpg' || file.type === 'image/jpeg' || file.type === 'image/png') {
                resolve(reader.result);
            }else {
                reject();
            }
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    });
};
