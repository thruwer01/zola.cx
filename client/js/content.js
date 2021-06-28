var page = 1;
const modal = document.createElement('div');


window.onload = () => {
    const search = document.querySelector('#search');

    const totalRecords = document.querySelector('#totalRecords');

    const typeFilter = document.querySelector('#typeFilter');
    const apiToken = document.querySelector('#apiToken');
    const contentList = document.querySelector('#contentList');
    const btnList = document.querySelector('#btnList');

    if (typeFilter.value != 3) {
        const yearFilter = document.querySelector('#yearFilter');
        const imdb = document.querySelector('#imdb');
        yearFilter.addEventListener('input', inputYearHandler);
        imdb.addEventListener('input', renderContent);
    }

    search.addEventListener('input', renderContent);

    renderContent();
    
}

function inputYearHandler() {
    if (yearFilter.value.length == 4) {
        renderContent();
    }
}

function closeModal() {
    modal.remove();
}


function renderContent () {
    let req = {
        "title": search.value,
        "api_token": apiToken.value,
        "category_id": typeFilter.value,
        "page": page
        
    }
    if (typeFilter.value != 3) {
        if (yearFilter.value.length == 4) {
            req['year'] = yearFilter.value;
        }
        if (imdb.value) {
            req['imdb_id'] = imdb.value;
        }
    }

    $.ajax({
        method: "GET",
        url: "/api/v1/short",
        data: req,
        beforeSend: function () {
            contentList.innerHTML = null;
        },
        success: (data) => {
            contentList.innerHTML = null;
            btnList.innerHTML = null;
            if (data.result == 'success') {
                data.data.forEach(content => {
                    let contentTr = document.createElement('tr');
                    if (typeFilter.value == 3) {
                        contentTr.innerHTML = `
                        <td>${content.title}</td>
                        <td><span id="imgPoster" class="avatar avatar-md" style="background-image: url(${content.poster})"></span></td>
                        <td>${content.date}</td>
                        <td>${content.quality}</td>
                        <td>${content.language}</td>
                        <td>${content.id}</td>
                        <td><button id="openContent" class="btn btn-primary">Open</button></td>
                        <td><button class="btn btn-primary" id="copyContent">Copy</button></td>
                        `;
                    } else {
                        contentTr.innerHTML = `
                        <td>${content.title}<div class="text-muted">${content.year}</div></td>
                        <td><span id="imgPoster" class="avatar avatar-md" style="background-image: url(${content.poster})"></span></td>
                        <td>${content.date}</td>
                        <td>${content.quality}</td>
                        <td>${content.language}</td>
                        <td>${content.id}</td>
                        <td>${content.imdb_id}</td>
                        <td><button id="openContent" class="btn btn-primary">Open</button></td>
                        <td><button class="btn btn-primary" id="copyContent">Copy</button></td>
                        `;
                    }
                    let imgPoster = document.querySelector('#imgPoster');
                    let openContentBtn = contentTr.querySelector('#openContent');
                    let copyContentBtn = contentTr.querySelector('#copyContent');
                    const body = document.querySelector('body');

                    copyContentBtn.onclick = () => {
                        $.ajax({
                            method: "GET",
                            url: "https://api.zola.cx/cdn.php?path="+content.path,
                            beforeSend: function () {
                                copyContentBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>';
                            },
                            success: (data) => {
                                modal.innerHTML = `
                                <div class="modal modal-blur fade show" id="modal-simple" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Iframe code -- ${content.title} (${content.year})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                        </div>
                                        <div class="modal-body">
                                                <textarea class="form-control" rows="5" id="copy">${data.trim()}</textarea>
                                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn me-auto" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                `;
                                // let copy = modal.querySelector('#copy');
                                // copy.select();
                                // document.execCommand('copy');
                                copyContentBtn.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M9 12l2 2l4 -4"></path>
                                    </svg>
                                    Copied
                                `;
                                body.appendChild(modal);

                            }
                        });
                    }


                    openContentBtn.onclick = () => {
                        $.ajax({
                            method: "GET",
                            url: "https://api.zola.cx/cdn.php?path="+content.path,
                            beforeSend: function () {
                                openContentBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>';
                            },
                            success: (data) => {
                                modal.innerHTML = `
                                <div class="modal modal-blur fade show" id="modal-simple" tabindex="-1" role="dialog" aria-modal="true" style="display: block;">
                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">${content.title} (${content.year})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img loading="lazy" src="${content.poster}">
                                                </div>
                                                <div class="col-8">
                                                    ${data}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn me-auto" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                `;
                                body.appendChild(modal);
                                openContentBtn.innerText = 'Open';
                            }
                        });
                    }


                    contentList.appendChild(contentTr);
                });

                if (data.total.value) {
                    totalRecords.innerText = data.total.value;
                }

                let pagesInfo = data.pages;
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
    });
}