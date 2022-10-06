(function ($) {
  $(document).ready(function () {
    const uploadInputs = document.querySelectorAll(".wpb_upload_input");
    const uploadButtons = document.querySelectorAll(".wpb_upload_btn");
    const uploadFilenames = document.querySelectorAll(".wpb_uploaded_filename");
    const uploadForms = document.querySelectorAll(".wpb_upload_form");

    uploadButtons.forEach((button, index) => {
      button.addEventListener("click", () => {
        uploadInputs[index].click();
        uploadInputs[index].addEventListener("change", () => {
          uploadFilenames[index].innerHTML = uploadInputs[index].files[0].name;
          uploadForms[index].submit();
          console.log(uploadInputs[index].files[0].lastModifiedDate);
        });
      });
    });
  });
})(jQuery);
