function formModalClose()
{
    if (Object.keys(errors).length > 0) {
        location.reload();
    }
    sessionStorage.removeItem('action');
    sessionStorage.removeItem('id');
}
