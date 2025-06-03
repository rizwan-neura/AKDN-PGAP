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
                $(`#${formId} .status-message`).text(response.message);
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
                    //alert(data.finalRating);
                    $(`.td-comp-name[data-indicator-id="planningFinalScore"]`).html(data.finalScore ?? '');
                    $(`.td-comp-name[data-indicator-id="planningRating"]`).html(data.finalRating ?? '');
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


