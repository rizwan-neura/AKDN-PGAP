function deleteRecord(
    id,
    formId,
    targetURL,
    reload = true,
    urlToRedirect = null
) {
    Swal.fire({
        title: "Delete!",
        text: "Are you sure you want to delete this record?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, do it!",
    }).then((result) => {
        if (result.isConfirmed) {
            var form = $("#" + formId + "_" + id);
            var data = form.serialize();
            let redirectURL = urlToRedirect
                ? urlToRedirect
                : targetURL.substr(0, targetURL.lastIndexOf("/"));
            $.ajax({
                type: "POST",
                url: targetURL,
                data: data,
                form: form,
                dataType: "json",
            })
                .done(function (data) {})
                .fail(function (jqXHR, textStatus, error) {
                    if (jqXHR.status !== 200) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: jqXHR.responseJSON.message,
                        });
                    } else {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Record has been deleted successfully.",
                            icon: "success",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (reload == true) {
                                    location.href = redirectURL;
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            return false;
        }
    });
}
function ajaxFormGet(formId, targetURL, fieldId) {
    var form = $("#" + formId);
    var data = form.serialize();
    $.ajax({
        type: "GET",
        url: targetURL,
        data: data,
        form: form,
        dataType: "json",
    }).done(function (response) {
            $("#" + fieldId).html(response.data);
              
        }).fail(function (jqXHR, textStatus, error) {
            
        });
    return false;
}

//headers: {
    //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//},

function saveIndicatorValues(formId, url, checklistId,deleteChecklistFileUrl) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Show status message
                $(`#${formId} .status-message`).text(response.message);
                // Remove existing file link (if any)
                $(`#${formId} .uploaded-file`).remove();
                // Append new file link after the file input
                if (response.file_url) {
                    let fileLink = `<div class="uploaded-file mt-2 d-block">📎 <a href="${response.file_url}" target="_blank">View Uploaded File</a>`;
                
                    if (response.can_delete && deleteChecklistFileUrl) {
                        fileLink += `
                            <button type="button" class="btn btn-danger waves-effect"
                                onclick="deleteChecklistFile('checklist_form_${checklistId}', '${deleteChecklistFileUrl}', ${checklistId}); return false;">
                                Delete file
                            </button>`;
                    }
                
                    fileLink += `</div>`;
                    $(`#${formId} input[type='file']`).after(fileLink);
                }
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            let message = res.message || 'Upload failed.';
            if (res.errors) {
                message = Object.values(res.errors).join('\n');
            }
            $(`#${formId} .status-message`).text(message).addClass('text-danger');
        }
    });
}


function deleteChecklistFile(formId, url, checklistId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
       // headers: {
    //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   // },
        success: function(response) {
            if (response.status === 'success') {
                $(`#${formId} .uploaded-file`).remove();
                $(`#${formId} .status-message`).text(response.message).removeClass('text-danger').addClass('text-success');
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            $(`#${formId} .status-message`).text(res.message || 'Deletion failed.').addClass('text-danger');
        }
    });
}
function savePlanningValues(formId, url, indicator_id,deleteFileUrl) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    //alert(formId);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Show status message
                $(`#${formId} .status-message`).text(response.message).addClass('text-success');
                // Remove existing file link (if any)
                $(`#${formId} .uploaded-file`).remove();
                // Append new file link after the file input
                if (response.file_url) {
                    let fileLink = `<div class="uploaded-file mt-2 d-block">📎 <a href="${response.file_url}" target="_blank">View Uploaded File</a>`;
                
                    if (response.can_delete && deleteFileUrl) {
                        fileLink += `
                            <button type="button" class="btn btn-danger waves-effect"
                                onclick="deletePlanningFile('planning_form_${indicator_id}', '${deleteFileUrl}', ${indicator_id}); return false;">
                                Delete file
                            </button>`;
                    }
                
                    fileLink += `</div>`;
                    $(`#${formId} input[type='file']`).after(fileLink);
                }

                // NEW: Update comp_name, complianceScore, and weightage in specific <td>
                const data = response.planning_review_info;
                if (data) {
                    //alert(data.finalScore);
                    $(`.td-finalscore[data-indicator-id="planningFinalScore"]`).html(data.finalScore ?? '');
                    $(`.td-finalrating[data-indicator-id="planningRating"]`).html(data.finalRating ?? '');
                    // comp_name
                    $(`.td-comp-name[data-indicator-id="${response.indicator_id}"]`).html(data.comp_name ?? '');
                     // complianceScore
                    $(`.td-comp-score[data-indicator-id="${response.indicator_id}"]`).html(data.complianceScore ?? '');
                    // weightage
                    const weightage = data.indicatorWeightage !== undefined ? Number(data.indicatorWeightage).toFixed(0) + '%' : '';
                    $(`.td-weightage[data-indicator-id="${response.indicator_id}"]`).html(weightage);
                }

            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            let message = res.message || 'Upload failed.';
            if (res.errors) {
                message = Object.values(res.errors).join('\n');
            }
            $(`#${formId} .status-message`).text(message).addClass('text-danger');
        }
    });
}

function deletePlanningFile(formId, url, indicator_id) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
       // headers: {
    //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   // },
        success: function(response) {
            if (response.status === 'success') {
                $(`#${formId} .uploaded-file`).remove();
                $(`#${formId} .status-message`).text(response.message).removeClass('text-danger').addClass('text-success');
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            $(`#${formId} .status-message`).text(res.message || 'Deletion failed.').addClass('text-danger');
        }
    });
}

function saveComments(formId, url, indicator_id) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    //alert(formId);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Show status message
                $(`#${formId} .status-message`).text(response.message);
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            let message = res.message || 'failed.';
            if (res.errors) {
                message = Object.values(res.errors).join('\n');
            }
            $(`#${formId} .status-message`).text(message).addClass('text-danger');
        }
    });
}

function updateCost(formId, url) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    //alert(formId);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Show status message
                $(`#${formId} .status-message`).text(response.message);
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            let message = res.message || 'failed.';
            if (res.errors) {
                message = Object.values(res.errors).join('\n');
            }
            $(`#${formId} .status-message`).text(message).addClass('text-danger');
        }
    });
}



function saveDesignValues(formId, url, indicator_id,deleteFileUrl) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    //alert(formId);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Show status message
                $(`#${formId} .status-message`).text(response.message);
                // Remove existing file link (if any)
                $(`#${formId} .uploaded-file`).remove();
                // Append new file link after the file input
                if (response.file_url) {
                    let fileLink = `<div class="uploaded-file mt-2 d-block">📎 <a href="${response.file_url}" target="_blank">View Uploaded File</a>`;
                
                    if (response.can_delete && deleteFileUrl) {
                        fileLink += `
                            <button type="button" class="btn btn-danger waves-effect"
                                onclick="deleteDesignFile('design_form_${indicator_id}', '${deleteFileUrl}', ${indicator_id}); return false;">
                                Delete file
                            </button>`;
                    }
                
                    fileLink += `</div>`;
                    $(`#${formId} input[type='file']`).after(fileLink);
                }

                // NEW: Update comp_name, complianceScore, and weightage in specific <td>
                const data = response.design_review_info;
                
                if (data) {
                    //alert(data.finalRating);
                    $(`.td-dfinalscore[data-indicator-id="designFinalScore"]`).html(data.finalScore ?? '');
                    $(`.td-dfinalrating[data-indicator-id="designRating"]`).html(data.finalRating ?? '');
                    // comp_name
                    $(`.td-dcomp-name[data-indicator-id="${response.indicator_id}"]`).html(data.comp_name ?? '');
                     // complianceScore
                    $(`.td-dcomp-score[data-indicator-id="${response.indicator_id}"]`).html(data.complianceScore ?? '');
                    // weightage
                    const weightage = data.indicatorWeightage !== undefined ? Number(data.indicatorWeightage).toFixed(0) + '%' : '';
                    $(`.td-dweightage[data-indicator-id="${response.indicator_id}"]`).html(weightage);
                }
                

            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            let message = res.message || 'Upload failed.';
            if (res.errors) {
                message = Object.values(res.errors).join('\n');
            }
            $(`#${formId} .status-message`).text(message).addClass('text-danger');
        }
    });
}

function deleteDesignFile(formId, url, indicator_id) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
       // headers: {
    //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   // },
        success: function(response) {
            if (response.status === 'success') {
                $(`#${formId} .uploaded-file`).remove();
                $(`#${formId} .status-message`).text(response.message).removeClass('text-danger').addClass('text-success');
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            $(`#${formId} .status-message`).text(res.message || 'Deletion failed.').addClass('text-danger');
        }
    });
}

function saveConstructionValues(formId, url, indicator_id,deleteFileUrl) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    //alert(formId);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                // Show status message
                $(`#${formId} .status-message`).text(response.message);
                // Remove existing file link (if any)
                $(`#${formId} .uploaded-file`).remove();
                // Append new file link after the file input
                if (response.file_url) {
                    let fileLink = `<div class="uploaded-file mt-2 d-block">📎 <a href="${response.file_url}" target="_blank">View Uploaded File</a>`;
                
                    if (response.can_delete && deleteFileUrl) {
                        fileLink += `
                            <button type="button" class="btn btn-danger waves-effect"
                                onclick="deleteConstructionFile('cons_form_${indicator_id}', '${deleteFileUrl}', ${indicator_id}); return false;">
                                Delete file
                            </button>`;
                    }
                
                    fileLink += `</div>`;
                    $(`#${formId} input[type='file']`).after(fileLink);
                }

                // NEW: Update comp_name, complianceScore, and weightage in specific <td>
                const data = response.cons_review_info;
                
                if (data) {
                    //alert(data.finalRating);
                    $(`.td-cfinalscore[data-indicator-id="consFinalScore"]`).html(data.finalScore ?? '');
                    $(`.td-cfinalrating[data-indicator-id="consRating"]`).html(data.finalRating ?? '');
                    // comp_name
                    $(`.td-ccomp-name[data-indicator-id="${response.indicator_id}"]`).html(data.comp_name ?? '');
                     // complianceScore
                    $(`.td-ccomp-score[data-indicator-id="${response.indicator_id}"]`).html(data.complianceScore ?? '');
                    // weightage
                    const weightage = data.indicatorWeightage !== undefined ? Number(data.indicatorWeightage).toFixed(0) + '%' : '';
                    $(`.td-cweightage[data-indicator-id="${response.indicator_id}"]`).html(weightage);
                }
                

            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            let message = res.message || 'Upload failed.';
            if (res.errors) {
                message = Object.values(res.errors).join('\n');
            }
            $(`#${formId} .status-message`).text(message).addClass('text-danger');
        }
    });
}

function deleteConstructionFile(formId, url, indicator_id) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
       // headers: {
    //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   // },
        success: function(response) {
            if (response.status === 'success') {
                $(`#${formId} .uploaded-file`).remove();
                $(`#${formId} .status-message`).text(response.message).removeClass('text-danger').addClass('text-success');
            }
        },
        error: function(xhr) {
            const res = xhr.responseJSON;
            $(`#${formId} .status-message`).text(res.message || 'Deletion failed.').addClass('text-danger');
        }
    });
}

/*
$(document).ready(function () {
    let oneMillion = parseFloat($('#min_cost').val());
    let fiveMillion = parseFloat($('#max_cost').val());
    let output_1 = $('#output_1').val();
    let output_2 = $('#output_2').val();
    let output_3 = $('#output_3').val();

    console.log({ oneMillion, fiveMillion, output_1, output_2, output_3 });

    const inputField = document.getElementById('construction_cost');
    const resultField = document.getElementById('requirements');


    if (!inputField || !resultField) return;

    inputField.addEventListener('input', function () {
        const value = this.value.trim();
        const num = parseFloat(value);
        let result = '';

        if (value === '') {
            result = 'Please enter a number';
            resultField.style.color = 'gray';
        } else if (isNaN(num)) {
            result = 'Invalid input';
            resultField.style.color = 'red';
        } else {
            if (num < oneMillion) {
                result = output_1;
                resultField.style.color = 'orange';
            } else if (num >= oneMillion && num < fiveMillion) {
                result = output_2;
                resultField.style.color = 'green';
            } else {
                result = output_3;
                resultField.style.color = 'red';
            }
        }
        console.log("Input:", value, "-> Requirement:", result);


        resultField.value = result;
    });
});

*/

/**
 * <form>
    @ csrf

    <label for="inputValue">Enter a number:</label>
    <input type="number" id="inputValue" name="inputValue" required>

    <br><br>

    <label for="result">Result:</label>
    <input type="text" id="result" readonly>

</form>
 <script>
    const j12 = {{ $threshold->j12 }};
    const j13 = {{ $threshold->j13 }};
    const k12 = @json($threshold->k12_value);
    const k13 = @json($threshold->k13_value);
    const k14 = @json($threshold->k14_value);

    let minCost = $('#min_cost').val();


    const inputField = document.getElementById('inputValue');
    const resultField = document.getElementById('result');

    inputField.addEventListener('input', function () {
        const value = this.value.trim();
        let result = '';

        if (value === '') {
            result = 'Please enter a number';
            resultField.style.color = 'gray';
        } else if (isNaN(value)) {
            result = 'Invalid input';
            resultField.style.color = 'red';
        } else {
            const num = parseFloat(value);
            if (num < j12) {
                result = k12;
                resultField.style.color = 'green';
            } else if (num >= j12 && num < j13) {
                result = k13;
                resultField.style.color = 'orange';
            } else {
                result = k14;
                resultField.style.color = 'red';
            }
        }

        resultField.value = result;
    });
</script>

 */


