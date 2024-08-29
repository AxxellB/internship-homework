<?php include 'common/header.php';
$currency_array = [
    'Euro', 'US Dollar', 'Bulgarian Lev', 'Cardano', 'Bitcoin', 'Ethereum', 'Tether'
];
?>
    <div class="sidebar-page-title-transactions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1">
                    <nav>
                        <div class="sidebar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/"><img
                                                src="static/img/image%201.png"> My
                                        Wallet</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="/internalTransactions.php"><img
                                                src="static/img/image%202.png"> Internal Transfer</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><img src="static/img/image%206.png"> Deposit</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><img src="static/img/image%204.png"> Exchange</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><img src="static/img/image%207.png"> Withdraw</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><img src="static/img/Frame.png"> Get Staking</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><img src="static/img/image%205.png"> Get Loan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/transactionHistory.php"><img
                                                src="static/img/image%203.png"> Transaction
                                        History</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-11">
                    <div class="page-title">
                        <div class="page-title-section-left">
                            <h1>Internal Transfer</h1>
                        </div>
                        <div class="page-title-section-right-position">
                            <div class="page-title-section-right">

                                <button class="btn-main">Deposit</button>
                                <button class="btn-secondary">Withdraw</button>
                                <button class="btn-secondary">Transfer</button>
                            </div>
                        </div>
                    </div>
                    <div class="custom-container">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="transfer-heading">Deposit to trading account</div>
                                <div class="card transfer-container mb-3" style="max-width: 25rem;">
                                    <div class="card-header">
                                        <div class="transfer-available">Available USDT: <span
                                                    class="transfer-amount"> 208849.74000 USDT</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="deposit-input">
                                            <input placeholder="Amount">
                                            <div class="dropdown">
                                                <select class="deposit-options">
                                                    <?php foreach ($currency_array as $currency) { ?>
                                                        <option value=<?php echo $currency ?><><?php echo $currency ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="card-btn-main">Deposit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="transfer-heading">Deposit to trading account</div>
                                <div class="card transfer-container mb-3" style="max-width: 25rem;">
                                    <div class="card-header">
                                        <div class="transfer-available">Available USDT: <span
                                                    class="transfer-amount"> 208849.74000 USDT</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="deposit-input">
                                            <input placeholder="Amount">
                                            <div class="dropdown">
                                                <select class="deposit-options">
                                                    <?php foreach ($currency_array as $currency) { ?>
                                                        <option value=<?php echo $currency ?><><?php echo $currency ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="card-btn-main">Withdraw</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'common/footer.php'; ?>