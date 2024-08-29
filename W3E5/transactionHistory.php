<?php include 'common/header.php';
$coins_array = [
    'Bitcoin', 'Ethereum', 'Cardano', 'Tether',
];
$transactions = [
    [
        "type" => "Deposit",
        "from_coin" => "12.000000 BTC",
        "to_coin" => "12.000000",
        "date" => "2022-02-28 13:09:00",
        "status" => "Approved"
    ],
    [
        "type" => "Exchange",
        "from_coin" => "1.000000 BTC",
        "to_coin" => "1.000000 ADA",
        "date" => "2022-02-28 13:09:21",
        "status" => "Approved"
    ],
    [
        "type" => "Deposit",
        "from_coin" => "1.000000 BTC",
        "to_coin" => "1.000000",
        "date" => "2022-02-28 14:53:02",
        "status" => "Waiting"
    ],
    [
        "type" => "Deposit",
        "from_coin" => "12.000000 BTC",
        "to_coin" => "12.000000",
        "date" => "2022-02-28 13:09:00",
        "status" => "Approved"
    ],
    [
        "type" => "Exchange",
        "from_coin" => "1.000000 BTC",
        "to_coin" => "1.000000 ADA",
        "date" => "2022-02-28 13:09:21",
        "status" => "Approved"
    ],
    [
        "type" => "Deposit",
        "from_coin" => "1.000000 BTC",
        "to_coin" => "1.000000",
        "date" => "2022-02-28 14:53:02",
        "status" => "Waiting"
    ]
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
                                <li class="nav-item">
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
                                <li class="nav-item active">
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
                            <h1>Transaction History</h1>
                        </div>
                        <div class="page-title-section-right-position">
                            <div class="page-title-section-right">

                                <button class="btn-main">Deposit</button>
                                <button class="btn-secondary">Withdraw</button>
                                <button class="btn-secondary">Transfer</button>
                            </div>
                        </div>
                    </div>
                    <div class="transaction-history-container">
                        <div class="transaction-history-filter">
                            <div class="transaction-filter">
                                <label>Select Coin</label>
                                <select class="deposit-options">
                                    <?php foreach ($coins_array as $coin) { ?>
                                        <option value=<?php echo $coin ?><><?php echo $coin ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="transaction-filter">
                                <label>Payment Type</label>
                                <input placeholder="All Type">
                            </div>
                            <div class="transaction-filter">
                                <label>Creation Date</label>
                                <input placeholder="From Date">
                            </div>
                            <div class="transaction-filter">
                                <label>End Date</label>
                                <input placeholder="To Date">
                            </div>
                            <div class="transaction-filter">
                                <label>Status</label>
                                <input placeholder="All">
                            </div>
                            <button class="transaction-filter-btn-main ">Search</button>
                        </div>
                        <div class="transaction-history-results-container">
                            <h3>History results</h3>
                            <div class="transaction-history-table-container">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            From coin
                                        </th>
                                        <th>
                                            To coin
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($transactions as $transaction) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $transaction['type'] ?>
                                            </td>
                                            <td>
                                                <?php echo $transaction['from_coin'] ?>
                                            </td>
                                            <td>
                                                <?php echo $transaction['to_coin'] ?>
                                            </td>
                                            <td>
                                                <?php echo $transaction['date'] ?>
                                            </td>
                                            <td class="<?php echo $transaction['status'] == "Approved" ? "transaction-success" : "transaction-waiting" ?>">
                                                <?php echo $transaction['status'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'common/footer.php'; ?>