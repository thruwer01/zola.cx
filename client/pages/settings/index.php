<div class="page-wrapper">
    <div class="container-xl">
        <div class="page-header">
            <h2 class="page-title">Settings</h2>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <div class="card-title">
                    Account Settings
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">
                            Telegram username
                        </label>
                        <input type="text" class="form-control" value="<?=$userTg?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            BTC / USDT Wallet
                        </label>
                        <input type="text" class="form-control" value="<?=$userWallet?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            My domains
                        </label>
                        <ul>
                            <li>domain.com</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Iframe token
                        </label>
                        <div class="row align-items-center">
                        <div class="col-12">
                            <b><?=$userIframeToken?></b>
                        </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            API token
                        </label>
                        <div class="row align-items-center">
                        <div class="col-12">
                            <b><?=$userApiToken?></b>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>