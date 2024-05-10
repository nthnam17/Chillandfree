/*
Template Name: Company Negaxy
*/

//Parameter
const btnDeletes = document.querySelectorAll('.sa-params');
for (const itemDelete of btnDeletes) {
    itemDelete.addEventListener("click",()=>{
        const id = itemDelete.getAttribute('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn bg-green-500 border-green-500 text-white mt-2',
            cancelButtonClass: 'btn bg-red-500 border-red-500 text-white ml-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    icon: 'success',
                    confirmButtonColor: '#5156be',
                })
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your imaginary file is safe :)',
                    icon: 'error',
                    confirmButtonColor: '#5156be',
                })
            }
        });
    })
}

const btnDepartment = document.querySelectorAll('.delete-department');
for (const itemDeleteDepartment of btnDepartment) {
    itemDeleteDepartment.addEventListener("click",()=>{
        const id = itemDeleteDepartment.getAttribute('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn bg-green-500 border-green-500 text-white mt-2',
            cancelButtonClass: 'btn bg-red-500 border-red-500 text-white ml-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    icon: 'success',
                    confirmButtonColor: '#5156be',
                })
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your imaginary file is safe :)',
                    icon: 'error',
                    confirmButtonColor: '#5156be',
                })
            }
        });
    })
}


