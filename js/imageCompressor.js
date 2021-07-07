import Compressor from "compressorjs";

function upload(file, image) {
    image.file = window.URL.createObjectURL(event.target.files[0]);
    compress(event.target.files[0], "1").then(function (vals) {
        file.file = vals[0];
    })
}

function compress(file, name) {
    return new Promise((resolve, reject) => {
        new Compressor(file, {
            quality: 0.4,
            success(result) {
                resolve([result, name]);
            },
            error(e) {
                reject(e)
            },
        });
    });
}

export {upload}
