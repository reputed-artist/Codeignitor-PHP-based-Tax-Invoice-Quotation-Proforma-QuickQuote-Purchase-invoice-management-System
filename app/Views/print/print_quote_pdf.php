<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Quotation - <?= esc($invDetails[0]['invid']); ?>
    </title>

    <!--
        NOTE: Do NOT include $this->include('include/links.php') here.
        Dompdf cannot load external stylesheets/frameworks (e.g. Bootstrap CDN)
        reliably. All styles needed for this document are inlined below.
    -->

    <style>

/* ==========================================================
   GLOBAL
   NOTE: Dompdf has partial CSS support. Avoid flexbox/grid;
   use tables/inline-block instead (done below).
========================================================== */

* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
}

body {
    background: #ffffff;
    font-family: Arial, Helvetica, sans-serif;
    color: #1f2937;
    font-size: 14px;
    line-height: 1.5;
}


/* ==========================================================
   A4 PAGE
========================================================== */

.quotation-page {
    width: 100%;

    padding: 13mm 15mm 15mm 15mm;

    position: relative;

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f8fbff 48%,
            #eef5ff 100%
        );

    border-top: 6px solid #172554;
}

/* Force a hard page break between the two quotation-page blocks */
.page-break {
    page-break-before: always;
}


/* ==========================================================
   COMPANY HEADER
========================================================== */

.company-header {
    width: 100%;
    padding-bottom: 10px;
}

.company-logo img {
    display: block;
    width: 100%;
    max-width: 100%;
    height: auto;
}

.header-line {
    width: 100%;
    height: 4px;
    margin-top: 10px;
    background: #2563eb; /* solid fallback - dompdf gradients on thin bars can be unreliable */
    border-radius: 4px;
}


/* ==========================================================
   REFERENCE / DATE
   (was display:flex -> converted to table)
========================================================== */

.quote-meta-table {
    width: 100%;
    border-collapse: collapse;

    margin-top: 14px;
    margin-bottom: 22px;

    font-size: 15px;
    line-height: 1.5;

    color: #111827;
}

.quote-meta-table td {
    padding: 0;
    vertical-align: middle;
}

.quote-reference {
    text-align: left;
    width: 50%;
}

.quote-date {
    text-align: right;
    width: 50%;
}


/* ==========================================================
   CUSTOMER DETAILS
========================================================== */

.customer-details {
    width: 100%;
    margin-bottom: 25px;
    font-size: 15px;
    line-height: 1.55;
    color: #111827;
}

.to-label {
    margin-bottom: 3px;
}

.customer-name-old {
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 2px;
}

.customer-address-old {
    font-size: 14px;
    line-height: 1.55;
    color: #374151;
}


/* ==========================================================
   KIND ATTENTION
========================================================== */

.attention {
    width: 100%;
    text-align: center;
    font-size: 15px;
    line-height: 1.5;
    margin-top: 8px;
    margin-bottom: 20px;
}


/* ==========================================================
   SUBJECT
========================================================== */

.subject-section {
    width: 100%;
    margin-top: 10px;
    margin-bottom: 22px;
}

.subject-label {
    font-size: 11px;
    line-height: 1.4;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    font-weight: bold;
    margin-bottom: 5px;
}

.subject {
    font-size: 16px;
    line-height: 1.4;
    font-weight: bold;
    color: #111827;
}

.subject-line {
    width: 80px;
    height: 4px;
    margin-top: 8px;
    background: #2563eb;
    border-radius: 5px;
}


/* ==========================================================
   INTRODUCTION
========================================================== */

.introduction {
    margin-top: 10px;
    margin-bottom: 18px;
    font-size: 14px;
    line-height: 1.6;
    color: #374151;
}


/* ==========================================================
   QUOTATION TABLE
========================================================== */

.quotation-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    line-height: 1.45;
}

.quotation-table thead th {
    background: #172554;
    color: #ffffff;
    padding: 12px 10px;
    font-size: 11px;
    line-height: 1.4;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: bold;
    border: none;
}

.quotation-table tbody td {
    border-right: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
    padding: 10px 9px;
    vertical-align: top;
    font-size: 13px;
    line-height: 1.45;
}

.quotation-table tbody tr:last-child td {
    border-bottom: none;
}

.quotation-table tbody td:last-child {
    border-right: none;
}

.quotation-table tbody tr.even-row {
    background: #eff6ff;
}

.quotation-table tbody tr {
    page-break-inside: avoid;
}

.sr {
    width: 7%;
    text-align: center;
    font-size: 13px;
    font-weight: bold;
}

.description {
    width: 58%;
}

.qty {
    width: 12%;
    text-align: center;
}

.amount {
    width: 23%;
    text-align: right;
}

.item-name {
    font-size: 14px;
    line-height: 1.4;
    font-weight: bold;
    color: #111827;
    margin-bottom: 8px;
}

.item-description {
    font-size: 13px;
    line-height: 1.45;
}

.item-description ul {
    margin: 5px 0 0 18px;
    padding: 0;
}

.item-description li {
    margin-bottom: 5px;
    font-size: 13px;
    line-height: 1.45;
    color: #4b5563;
}

.qty strong {
    font-size: 14px;
    line-height: 1.4;
}

.qty-label {
    font-size: 10px;
    line-height: 1.3;
    color: #9ca3af;
    margin-top: 3px;
}

.amount strong {
    font-size: 13px;
    line-height: 1.4;
    color: #111827;
    white-space: nowrap;
}


/* ==========================================================
   TOTALS
   (was display:flex -> converted to table, right-aligned)
========================================================== */

.totals-wrapper-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 14px;
}

.totals-spacer {
    width: 60%;
}

.totals-box {
    width: 40%;
    min-width: 260px;
    vertical-align: top;
}

.totals-inner {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #cbd5e1;
    font-size: 13px;
}

.total-row td {
    padding: 9px 13px;
    border-bottom: 1px solid #e5e7eb;
    background: #ffffff;
    font-size: 13px;
    line-height: 1.4;
}

.total-label {
    color: #6b7280;
    font-weight: 600;
    text-align: left;
}

.total-value {
    color: #111827;
    font-weight: bold;
    text-align: right;
}

.grand-total-row td {
    padding: 12px 13px;
    background: #172554;
    color: #ffffff;
    font-size: 15px;
    line-height: 1.4;
    font-weight: bold;
    border-bottom: none;
}

.grand-total-row .total-value {
    color: #ffffff;
    font-size: 16px;
}


/* ==========================================================
   CONTINUED
========================================================== */

.continued {
    margin-top: 35px;
    text-align: right;
    color: #6b7280;
    font-size: 12px;
    line-height: 1.4;
}


/* ==========================================================
   SECTION TITLES
========================================================== */

.section-title {
    font-size: 15px;
    line-height: 1.4;
    font-weight: bold;
    color: #172554;
    padding-bottom: 9px;
    margin-bottom: 15px;
    border-bottom: 3px solid #2563eb; /* substitute for ::after underline (dompdf skips ::after reliably in some builds) */
}


/* ==========================================================
   PRODUCT IMAGE
========================================================== */

.product-image-box {
    text-align: center;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background: #ffffff;
    page-break-inside: avoid;
}

.product-image-box img {
    display: block;
    width: 100%;
    max-width: 100%;
    height: 260px;
    margin: 0 auto;
}

.product-image-name {
    font-size: 14px;
    line-height: 1.4;
    font-weight: bold;
    color: #111827;
    margin-top: 10px;
}


/* ==========================================================
   TERMS
========================================================== */

.terms {
    margin-top: 22px;
}

.terms p {
    margin: 8px 0;
    font-size: 14px;
    line-height: 1.55;
    color: #374151;
}

.terms strong {
    color: #111827;
}


/* ==========================================================
   BANK DETAILS
   (was display:grid -> converted to table, 2 columns)
========================================================== */

.bank-section {
    margin-top: 25px;
}

.bank-grid-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 12px;
}

.bank-card-cell {
    width: 50%;
    vertical-align: top;
    padding: 6px; /* replaces border-spacing */
}

.bank-card {
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 12px;
    font-size: 13px;
    line-height: 1.7;
    background: #ffffff;
    page-break-inside: avoid;
}

.bank-name {
    font-size: 14px;
    line-height: 1.4;
    font-weight: bold;
    margin-bottom: 5px;
    color: #172554;
}

.bank-label {
    color: #6b7280;
}


/* ==========================================================
   CLOSING
========================================================== */

.closing {
    margin-top: 25px;
    font-size: 14px;
    line-height: 1.6;
    color: #374151;
}

.closing p {
    margin: 8px 0;
}


/* ==========================================================
   SIGNATURE
========================================================== */

.signature {
    margin-top: 25px;
    font-size: 14px;
    line-height: 1.6;
}

.signature-line {
    margin: 12px 0;
    font-size: 18px;
    line-height: 1.4;
    color: #555;
}

.signature-name {
    font-size: 14px;
    line-height: 1.5;
    font-weight: bold;
    color: #111827;
}

.mobile {
    float: right;
    font-size: 14px;
    font-weight: bold;
}


/* ==========================================================
   A4 PRINT SIZE
========================================================== */

@page {
    size: A4;
    margin: 0;
}

    </style>

</head>


<body>


<?php

/* ==========================================================
   INVOICE DATA
========================================================== */

$invoice = $invDetails[0];

$formattedQuoteDate = !empty($invoice['created'])
    ? date('d-m-Y', strtotime($invoice['created']))
    : '';

?>


<!-- ==========================================================
     PAGE 1
========================================================== -->

<div class="quotation-page">


    <!-- COMPANY LOGO -->

    <div class="company-header">

        <div class="company-logo">

            <!-- <img
                src="<?= base_url('public/dist/img/sticker Letter colorpad.png'); ?>"
                alt="CodeTech Engineers"
            > -->
            <img src="<?= FCPATH . 'public/dist/img/sticker Letter colorpad.png'; ?>" alt="CodeTech Engineers">

        </div>

        <div class="header-line"></div>

    </div>


    <!-- REFERENCE + DATE (table-based, replaces flex) -->

    <table class="quote-meta-table">
        <tr>
            <td class="quote-reference">
                <strong>Ref.: <?= esc($invoice['invid']); ?></strong>
            </td>
            <td class="quote-date">
                <strong>Date: <?= $formattedQuoteDate; ?></strong>
            </td>
        </tr>
    </table>


    <!-- CUSTOMER -->

    <div class="customer-details">

        <div class="to-label">To,</div>

        <div class="customer-name-old">
            <strong>M/s. <?= esc($invoice['c_name']); ?></strong>
        </div>

        <div class="customer-address-old">

            <?php

            $address = trim($invoice['c_add'] ?? '');

            if ($address !== '') {

                $lines = preg_split(
                    '/\r\n|\r|\n/',
                    wordwrap($address, 45, "\n")
                );

                foreach ($lines as $line) {

                    if (trim($line) !== '') {

                        echo esc(trim($line)) . '<br>';

                    }

                }

            }

            ?>

        </div>

    </div>


    <!-- KIND ATTENTION -->

    <div class="attention">
        <strong>Kind Attn.: Mr.</strong>
    </div>


    <!-- SUBJECT -->

    <div class="subject-section">

        <div class="subject-label">Subject</div>

        <div class="subject">
            Quotation for <?= esc($cattype); ?> Batch Coding Machines
        </div>

        <div class="subject-line"></div>

    </div>


    <!-- INTRODUCTION -->

    <div class="introduction">

        Dear Sir/Madam,

        <br><br>

        We are pleased to submit our quotation for the following
        batch coding machine as per your requirement.

    </div>


    <!-- PRODUCT TABLE -->

    <table class="quotation-table">

        <thead>
            <tr>
                <th class="sr">#</th>
                <th class="description">Description</th>
                <th class="qty">Qty.</th>
                <th class="amount">
                    Amount
                    <br>
                    <small>EXW INR</small>
                </th>
            </tr>
        </thead>

        <tbody>

        <?php

        $cnt = 1;
        $extracol = null;
        $extracol2 = 0;
        $rowIndex = 0;

        foreach ($itemDetails as $item):

            if (
                $item['item_name'] == "Courier" ||
                $item['item_name'] == "Freight Charges" ||
                $item['item_name'] == "Wooden Packing" ||
                $item['item_name'] == "Packing and forwarding"
            ) {
                $extracol = $item['item_name'];
                $extracol2 = $item['total'];
            }

            $rowIndex++;
            $rowClass = ($rowIndex % 2 === 0) ? 'even-row' : '';

        ?>

            <tr class="<?= $rowClass; ?>">

                <td class="sr"><?= $cnt++; ?></td>

                <td class="description">

                    <div class="item-name"><?= esc($item['item_name']); ?></div>

                    <?php

                    $techData = $item['techs'] ?? '';
                    $features = explode(';', $techData);

                    ?>

                    <?php if (!empty($features)): ?>

                        <div class="item-description">
                            <ul>

                            <?php foreach ($features as $feature): ?>

                                <?php $feature = trim($feature); ?>

                                <?php if ($feature !== ''): ?>

                                    <li><?= esc(stripcslashes($feature)); ?></li>

                                <?php endif; ?>

                            <?php endforeach; ?>

                            </ul>
                        </div>

                    <?php endif; ?>

                </td>

                <td class="qty">
                    <strong><?= esc($item['quantity']); ?></strong>
                    <div class="qty-label">No.</div>
                </td>

                <td class="amount">
                    <strong>
                        &#8377; <?= number_format((float)$item['total'], 2, '.', ','); ?>
                    </strong>
                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>


    <!-- TOTALS (table-based, replaces flex) -->

    <table class="totals-wrapper-table">
        <tr>
            <td class="totals-spacer"></td>
            <td class="totals-box">

                <table class="totals-inner">

                    <?php if (!empty($extracol)): ?>

                        <tr class="total-row">
                            <td class="total-label"><?= esc($extracol); ?></td>
                            <td class="total-value">
                                &#8377; <?= number_format((float)$extracol2, 2, '.', ','); ?>
                            </td>
                        </tr>

                    <?php endif; ?>

                    <tr class="total-row">
                        <td class="total-label">
                            GST <?= number_format((float)($invoice['taxrate'] ?? 18), 2); ?>%
                        </td>
                        <td class="total-value">
                            &#8377; <?= number_format((float)$invoice['taxamount'], 2, '.', ','); ?>
                        </td>
                    </tr>

                    <tr class="grand-total-row">
                        <td>TOTAL</td>
                        <td class="total-value">
                            &#8377; <?= number_format((float)$invoice['totalamount'], 2, '.', ','); ?>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>


    <!-- CONTINUED -->

    <div class="continued">
        <strong>Continued on next page...</strong>
    </div>


</div>



<!-- ==========================================================
     PAGE 2
========================================================== -->

<div class="quotation-page page-break">


    <!-- PRODUCT DETAILS -->

    <div class="section-title">Product Details</div>

    <?php foreach ($itemDetails as $item): ?>

        <?php if (!empty($item['img_loc'])): ?>

            <div class="product-image-box">

                <img
                    src="<?= base_url('public/dist/img/' . $item['img_loc']); ?>"
                    alt="<?= esc($item['item_name']); ?>"
                >

                <div class="product-image-name">
                    <?= esc($item['item_name']); ?>
                </div>

            </div>

        <?php endif; ?>

    <?php endforeach; ?>


    <!-- TERMS & CONDITIONS -->

    <div class="terms">

        <div class="section-title">Terms & Conditions</div>

        <p><strong>A.</strong> Above prices are Ex-Works Ahmedabad. Transportation charges are extra.</p>

        <p><strong>B. Payment Terms:</strong> 50% Advance along with confirmed P.O. and balance 50% against Proforma Invoice before dispatch after inspection.</p>

        <p><strong>C. Delivery:</strong> Within 3–4 weeks from the date of receipt of confirmed P.O. along with advance.</p>

        <p><strong>D. Installation:</strong> Installation will be provided free of cost from our side.</p>

        <p><strong>E.</strong> The design and prices are subject to change for any changes/additions in the above specifications.</p>

        <p><strong>F. Warranty:</strong> 1 year from the date of delivery against manufacturing defects. The warranty covers free replacement of defective parts, if any.</p>

        <p><strong>G.</strong> Order once placed cannot be cancelled under any circumstances. In case of cancellation, the entire amount of advance payment will stand forfeited.</p>

    </div>


    <!-- BANK DETAILS (table-based, replaces grid) -->

    <div class="bank-section">

        <div class="section-title">Bank Details</div>

        <table class="bank-grid-table">

            <?php
            $bankChunks = array_chunk($bankDetails, 2);
            foreach ($bankChunks as $pair):
            ?>

                <tr>

                    <?php foreach ($pair as $bank): ?>

                        <td class="bank-card-cell">

                            <div class="bank-card">

                                <div>
                                    <span class="bank-label">Account Name:</span>
                                    <?= esc("Codetech Engineers"); ?>
                                </div>

                                <div class="bank-name">
                                    <span class="bank-label">Bank Name:</span>
                                    <?= esc($bank['bname']); ?>
                                </div>

                                <div>
                                    <span class="bank-label">A/C No:</span>
                                    <?= esc($bank['ac']); ?>
                                </div>

                                <div>
                                    <span class="bank-label">IFSC:</span>
                                    <?= esc($bank['ifsc']); ?>
                                </div>

                                <div>
                                    <span class="bank-label">Branch:</span>
                                    <?= esc($bank['branch']); ?>
                                </div>

                            </div>

                        </td>

                    <?php endforeach; ?>

                    <?php if (count($pair) === 1): ?>
                        <td class="bank-card-cell"></td>
                    <?php endif; ?>

                </tr>

            <?php endforeach; ?>

        </table>

    </div>


    <!-- CLOSING -->

    <div class="closing">

        <p>We hope that the above offer is technically in line with your requirement.</p>

        <p>Thanking you and looking forward to receiving your valuable Purchase Order.</p>

    </div>


    <!-- SIGNATURE -->

    <div class="signature">

        <div>Yours truly,</div>

        <div style="margin-top:15px;">
            <strong>From CodeTech Engineers</strong>
        </div>

        <div class="signature-line">-----sd------</div>

        <div class="signature-name">
            Kamlesh Chavda
            <span class="mobile">Mob.: +91-9737693302</span>
        </div>

    </div>


</div>


</body>

</html>