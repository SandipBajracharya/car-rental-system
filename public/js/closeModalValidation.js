function formModalClose()
{
    if (Object.keys(errors).length > 0) {
        location.reload();
    }
    sessionStorage.removeItem('action');
    sessionStorage.removeItem('id');
    let list = document.getElementById('e-vehicle_image_item');
    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
}
