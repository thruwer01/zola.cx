const modal = document.createElement('div');

function closeModal () {
    modal.remove();
}

window.onload = () => {
    const body = document.querySelector('body');
    const usersList = document.querySelector('#usersList');
    const btnList = document.querySelector('#btnList');

    var page = 1;

    function getUsers () {
        return $.ajax({
            method: "GET",
            url: "/api/v1/users",
            data: {
                page
            }
        })
    }

    function blockUser(id) {
        console.log(id);
    }

    async function renderUsers() {
        let users = await getUsers();
        
        if (users.result == 'success') {
            btnList.innerHTML = null;
            usersList.innerHTML = null;
            users.data.forEach(user => {
                let userTr = document.createElement('tr');
                userTr.classList.add('align-items-center');
                userTr.innerHTML = `
                    <td>${user.email}</td>
                    <td><button class="btn btn-warning" data-user-id="${user.id}" data-user-access="${user.access}" id="changeUserAccess">
                        `+( (user.access == 1) ? 'Deactivate' : 'Activate' )+`
                        </button>
                    </td>
                    <td><button class="btn btn-primary" data-user-id="${user.id}" id="blockUser">Block User</button></td>
                    <td><button class="btn btn-danger" data-user-id="${user.id}" id="removeUser">Remove User</button></td>
                `;
                let changeAccessBtn = userTr.querySelector('#changeUserAccess');
                let blockUserBtn = userTr.querySelector('#blockUser');
                let removeUserBtn = userTr.querySelector('#removeUser');

                changeAccessBtn.onclick = () => {
                    let userId = changeAccessBtn.dataset.userId;
                    let userAccess = changeAccessBtn.dataset.userAccess;
                    if (userAccess == 1) {
                        $.ajax({
                            method: "POST",
                            url: "/api/v1/users/deactivate/index.php",
                            data: {id: userId},
                            success: (data) => {
                                console.log(data);
                                renderUsers();
                            }
                        });
                    } else {
                        $.ajax({
                            method: "POST",
                            url: "/api/v1/users/activate/index.php",
                            data: {id: userId},
                            success: (data) => {
                                console.log(data);
                                renderUsers();
                            }
                        });
                    }
                }

                blockUserBtn.onclick = () => {
                    let userId = changeAccessBtn.dataset.userId;
                    modal.innerHTML = `
                        <div class="modal modal-blur fade show" id="modal-simple" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Block user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label">On what period in hours?</label>
                                <input class="form-control" type="text" placeholder="24" require id="time">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="blockUser">Block User</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    `;
                    let timeInput = modal.querySelector('#time');
                    timeInput.oninput = function () {
                        timeInput.value = timeInput.value.trim().replace(/[^0-9]/g, '');
                    }
                    let blockUser = modal.querySelector('#blockUser');
                    blockUser.onclick = () => {
                        if (timeInput.value.length > 0) {
                            $.ajax({
                                method: "POST",
                                url: "/api/v1/users/block/index.php",
                                data: { time: timeInput.value, id: userId },
                                success: (data) => {
                                    closeModal(); 
                                }
                            });
                        }
                    }
                    body.appendChild(modal);
                }

                removeUserBtn.onclick = () => {
                    let userId = changeAccessBtn.dataset.userId;
                    modal.innerHTML = `
                        <div class="modal modal-blur fade show" id="modal-danger" tabindex="-1" role="dialog" aria-modal="true" style="display: block; padding-left: 6px;">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                            <div class="modal-status bg-danger"></div>
                            <div class="modal-body text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg>
                            <h3>Are you sure?</h3>
                            <div class="text-muted">Do you really want to remove this user?</div>
                            </div>
                            <div class="modal-footer">
                            <div class="w-100">
                                <div class="row">
                                <div class="col"><a href="#" onclick="closeModal()" class="btn btn-white w-100" data-bs-dismiss="modal">
                                    Cancel
                                </a></div>
                                <div class="col"><a href="#" id="removeUser" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                    Remove
                                    </a></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    `;
                    modal.querySelector('#removeUser').onclick = () => {
                        $.ajax({
                            method: "POST",
                            url: "/api/v1/users/delete/index.php",
                            data: {id : userId},
                            success: (data) => {
                                closeModal();
                                renderUsers();
                            }
                        });
                    }
                    body.appendChild(modal);
                }

                usersList.appendChild(userTr);
            });

            let pagesInfo = users.pages;
                if (pagesInfo.prev_page) {
                    let pageLi = document.createElement('li');
                    pageLi.classList.add('page-item');
                    pageLi.innerHTML = `<a href="${pagesInfo.prev_page_url}" class="page-link">${pagesInfo.prev_page}</a>`;
                    btnList.appendChild(pageLi);
                }

                let pageLi = document.createElement('li');
                pageLi.classList.add('page-item');
                pageLi.classList.add('active');
                pageLi.innerHTML = `<a class="page-link">${pagesInfo.current_page}</a>`;
                btnList.appendChild(pageLi);

                if (pagesInfo.next_page) {
                    let pageLi = document.createElement('li.page-item');
                    pageLi.innerHTML = `<a href="${pagesInfo.next_page_url}" class="page-link">${pagesInfo.next_page}</a>`;
                    btnList.appendChild(pageLi);
                }
                if (pagesInfo.last_page) {
                    let pageLi = document.createElement('li.page-item');
                    pageLi.innerHTML = `<a href="${pagesInfo.last_page_url}" class="page-link">${pagesInfo.last_page}</a>`;
                    btnList.appendChild(pageLi);

                }
        }
    }
    renderUsers();
}

