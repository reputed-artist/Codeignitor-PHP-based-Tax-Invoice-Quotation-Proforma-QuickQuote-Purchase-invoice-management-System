<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Print Quick Quotation
    </title>

    <?= $this->include('include/links.php'); ?>


<style>

/* ==========================================================
   GLOBAL
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
    background: #e5e7eb;
    font-family: Arial, Helvetica, sans-serif;
    color: #1f2937;
    font-size: 14px;
    line-height: 1.5;
}


/* ==========================================================
   A4 PAGE
========================================================== */

.quotation-page {
    width: 210mm;
    min-height: 297mm;

    margin: 25px auto;

    padding: 13mm 15mm 15mm 15mm;

    position: relative;
    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #ffffff 0%,
            #f8fbff 48%,
            #eef5ff 100%
        );

    border-top: 6px solid #172554;

    box-shadow:
        0 4px 25px rgba(0, 0, 0, 0.12);
}


/* ==========================================================
   PREMIUM ABSTRACT BACKGROUND
========================================================== */

.quotation-page::before {
    content: "";

    position: absolute;

    top: -180px;
    right: -150px;

    width: 430px;
    height: 430px;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #172554,
            #2563eb,
            #06b6d4
        );

    opacity: 0.10;

    pointer-events: none;
}


.quotation-page::after {
    content: "";

    position: absolute;

    bottom: -180px;
    left: -170px;

    width: 420px;
    height: 420px;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #06b6d4,
            #2563eb,
            #172554
        );

    opacity: 0.08;

    pointer-events: none;
}


/* Keep content above abstract background */

.quotation-page > * {
    position: relative;
    z-index: 2;
}


/* ==========================================================
   COMPANY HEADER
========================================================== */

.company-header {
    width: 100%;
    padding-bottom: 10px;
    position: relative;
}


.company-logo {
    width: 100%;
}


.company-logo img {
    display: block;

    width: 100%;
    max-width: 100%;
    height: auto;

    image-rendering: -webkit-optimize-contrast;
}


/* ==========================================================
   PDF-SAFE HEADER LINE
========================================================== */

.header-line {
    width: 100%;
    height: 4px;

    margin-top: 10px;

    background:
        linear-gradient(
            90deg,
            #172554 0%,
            #2563eb 45%,
            #06b6d4 75%,
            #94a3b8 100%
        );

    border-radius: 4px;

    display: block;

    position: relative;
    z-index: 10;
}


/* ==========================================================
   REFERENCE + DATE
========================================================== */

.quote-meta {
    width: 100%;

    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-top: 14px;
    margin-bottom: 22px;

    font-size: 15px;
    line-height: 1.5;

    color: #111827;
}


.quote-reference {
    text-align: left;
}


.quote-date {
    text-align: right;
    margin-right: 20px;
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


.customer-name {
    font-size: 15px;

    font-weight: bold;

    margin-bottom: 3px;
}


.customer-line {
    font-size: 15px;
    line-height: 1.5;

    color: #374151;

    min-height: 20px;
}


/* ==========================================================
   CONTENT EDITABLE
========================================================== */

*[contenteditable] {
    border-radius: 4px;

    min-width: 1em;

    outline: 0;

    cursor: pointer;
}


*[contenteditable]:hover {
    background: rgba(219, 234, 254, 0.45);

    box-shadow:
        0 0 0 2px rgba(37, 99, 235, 0.08);
}


*[contenteditable]:focus {
    background: rgba(219, 234, 254, 0.55);

    box-shadow:
        0 0 0 2px rgba(37, 99, 235, 0.12);
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

    background:
        linear-gradient(
            90deg,
            #172554,
            #2563eb,
            #06b6d4
        );

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

    border-collapse: separate;

    border-spacing: 0;

    margin-top: 12px;

    border: 1px solid #cbd5e1;

    border-radius: 7px;

    overflow: hidden;

    font-size: 13px;

    line-height: 1.45;

    box-shadow:
        0 4px 15px rgba(23, 37, 84, 0.06);
}


/* ==========================================================
   TABLE HEADER
========================================================== */

.quotation-table thead th {
    background:
        linear-gradient(
            135deg,
            #172554,
            #1e3a8a,
            #2563eb
        );

    color: #ffffff;

    padding: 12px 10px;

    font-size: 11px;

    line-height: 1.4;

    text-transform: uppercase;

    letter-spacing: 0.5px;

    font-weight: bold;

    border: none;
}


/* ==========================================================
   TABLE BODY
========================================================== */

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


.quotation-table tbody tr:nth-child(even) {
    background: rgba(239, 246, 255, 0.65);
}


.quotation-table tbody tr {
    page-break-inside: avoid;
}


/* ==========================================================
   TABLE COLUMNS
========================================================== */

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


/* ==========================================================
   ITEM
========================================================== */

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
========================================================== */

.totals-wrapper {
    width: 100%;

    display: flex;

    justify-content: flex-end;

    margin-top: 14px;
}


.totals {
    width: 300px;

    border: 1px solid #cbd5e1;

    border-radius: 7px;

    overflow: hidden;

    font-size: 13px;

    box-shadow:
        0 5px 18px rgba(23, 37, 84, 0.08);
}


.total-row {
    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 9px 13px;

    border-bottom: 1px solid #e5e7eb;

    background: #ffffff;

    font-size: 13px;

    line-height: 1.4;
}


.total-row:last-child {
    border-bottom: none;
}


.total-label {
    color: #6b7280;

    font-weight: 600;
}


.total-value {
    color: #111827;

    font-weight: bold;
}


.grand-total {
    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 12px 13px;

    background:
        linear-gradient(
            135deg,
            #172554,
            #1e3a8a,
            #2563eb
        );

    color: #ffffff;

    font-size: 15px;

    line-height: 1.4;

    font-weight: bold;
}


.grand-total span:last-child {
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
   PAGE 2 SECTION TITLES
========================================================== */

.section-title {
    position: relative;

    font-size: 15px;

    line-height: 1.4;

    font-weight: bold;

    color: #172554;

    padding-bottom: 9px;

    margin-bottom: 15px;
}


.section-title::after {
    content: "";

    position: absolute;

    left: 0;

    bottom: 0;

    width: 55px;

    height: 3px;

    border-radius: 4px;

    background:
        linear-gradient(
            90deg,
            #172554,
            #2563eb,
            #06b6d4
        );
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

    background:
        rgba(255, 255, 255, 0.82);

    box-shadow:
        0 5px 20px rgba(23, 37, 84, 0.07);

    page-break-inside: avoid;
}


.product-image-box img {
    display: block;

    width: 100%;

    max-width: 100%;

    height: 260px;

    object-fit: contain;

    margin: 0 auto;

    image-rendering: -webkit-optimize-contrast;
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
========================================================== */

.bank-section {
    margin-top: 25px;
}


.bank-grid {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 12px;

    margin-top: 12px;
}


.bank-card {
    border: 1px solid #cbd5e1;

    border-radius: 6px;

    padding: 12px;

    font-size: 13px;

    line-height: 1.7;

    background:
        rgba(255, 255, 255, 0.80);

    box-shadow:
        0 4px 14px rgba(23, 37, 84, 0.05);

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

    font-weight: 600;
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
   PRINT
========================================================== */

@media print {

    html,
    body {
        width: 210mm;

        margin: 0;

        padding: 0;

        background: #ffffff;

        font-family: Arial, Helvetica, sans-serif;
    }


    .quotation-page {
        width: 210mm;

        min-height: 297mm;

        margin: 0;

        padding: 13mm 15mm 15mm 15mm;

        box-shadow: none;

        page-break-after: always;

        background:
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f8fbff 48%,
                #eef5ff 100%
            ) !important;

        border-top: 6px solid #172554 !important;
    }


    .quotation-page:last-child {
        page-break-after: auto;
    }


    .header-line {
        display: block !important;

        visibility: visible !important;

        opacity: 1 !important;

        height: 4px !important;

        min-height: 4px !important;

        background: #2563eb !important;

        -webkit-print-color-adjust: exact !important;

        print-color-adjust: exact !important;
    }


    .quotation-table tbody tr,
    .product-image-box,
    .bank-card {
        page-break-inside: avoid;
    }


    * {
        -webkit-print-color-adjust: exact !important;

        print-color-adjust: exact !important;
    }
}


/* ==========================================================
   A4
========================================================== */

@page {
    size: A4;

    margin: 0;
}

</style>

</head>


<body>


<div id="loader"></div>


<?php

/* ==========================================================
   QUICK QUOTATION DATA
========================================================== */

$dv = json_decode($dv, true);

$quickQuote = !empty($dv) ? $dv[0] : [];

$quoteId = $quickQuote['q_id'] ?? '';

$quoteDate = !empty($quickQuote['created'])
    ? date('d-m-Y', strtotime($quickQuote['created']))
    : date('d-m-Y');

$itemName = $quickQuote['name'] ?? '';

$techs = $quickQuote['techs'] ?? '';

$quantity = $quickQuote['quantity'] ?? 0;

$subtotal = (float)($quickQuote['subtotal'] ?? 0);

$gst = (float)($quickQuote['gst'] ?? 0);

$grandTotal = (float)($quickQuote['total'] ?? 0);

$imageLocation = $quickQuote['img_loc'] ?? '';

$features = explode(';', $techs);

?>


<!-- ==========================================================
     PAGE 1
========================================================== -->

<div class="quotation-page">


    <!-- ======================================================
         COMPANY HEADER
    ======================================================= -->

    <div class="company-header">

        <div class="company-logo">

            <img
                src="<?= base_url('public/dist/img/sticker Letter colorpad.png'); ?>"
                alt="CodeTech Engineers"
            >

        </div>


        <div class="header-line"></div>

    </div>


    <!-- ======================================================
         REFERENCE + DATE
    ======================================================= -->

    <div class="quote-meta">


        <div class="quote-reference">

            <strong>
                Ref.: <?= esc($quoteId); ?>
            </strong>

        </div>


        <div class="quote-date">

            <strong>
                Date: <?= esc($quoteDate); ?>
            </strong>

        </div>


    </div>


    <!-- ======================================================
         CUSTOMER DETAILS
    ======================================================= -->

    <div class="customer-details">


        <div class="to-label">
            To,
        </div>


        <div
            class="customer-name"
            contenteditable
        >

            M/s.

        </div>


        <div
            class="customer-line"
            contenteditable
        >

            <!-- Customer address / details -->

        </div>


        <div
            class="customer-line"
            contenteditable
        >

        </div>


        <div
            class="customer-line"
            contenteditable
        >

        </div>


        <div
            class="customer-line"
            contenteditable
        >

            <?= htmlspecialchars($quickQuote['mob'] ?? ''); ?>

        </div>


    </div>


    <!-- ======================================================
         KIND ATTENTION
    ======================================================= -->

    <div
        class="attention"
        contenteditable
    >

        <strong>
            Kind Attn.: Mr.
        </strong>

    </div>


    <!-- ======================================================
         SUBJECT
    ======================================================= -->

    <div class="subject-section">


        <div class="subject-label">
            Subject
        </div>


        <div
            class="subject"
            contenteditable
        >

            Quotation for
            <?= esc($cattype); ?>
            Batch Coding Machines

        </div>


        <div class="subject-line"></div>


    </div>


    <!-- ======================================================
         INTRODUCTION
    ======================================================= -->

    <div class="introduction">


        Dear Sir/Madam,


        <br><br>


        We are pleased to submit our quotation for the following
        batch coding machine as per your requirement.


    </div>


    <!-- ======================================================
         PRODUCT TABLE
    ======================================================= -->

    <table class="quotation-table">


        <thead>

            <tr>

                <th class="sr">
                    #
                </th>


                <th class="description">
                    Description
                </th>


                <th class="qty">
                    Qty.
                </th>


                <th class="amount">

                    Amount

                    <br>

                    <small>
                        EXW INR
                    </small>

                </th>

            </tr>

        </thead>


        <tbody>


            <tr>


                <!-- SERIAL -->

                <td class="sr">

                    1

                </td>


                <!-- DESCRIPTION -->

                <td
                    class="description"
                    contenteditable
                >


                    <div class="item-name">

                        <?= esc($itemName); ?>

                    </div>


                    <?php if (!empty($features)): ?>


                        <div class="item-description">


                            <ul>


                                <?php foreach ($features as $feature): ?>


                                    <?php

                                    $feature = trim($feature);

                                    ?>


                                    <?php if ($feature !== ''): ?>


                                        <li>

                                            <?= esc(
                                                stripcslashes($feature)
                                            ); ?>

                                        </li>


                                    <?php endif; ?>


                                <?php endforeach; ?>


                            </ul>


                        </div>


                    <?php endif; ?>


                </td>


                <!-- QUANTITY -->

                <td class="qty">


                    <strong>

                        <?= esc($quantity); ?>

                    </strong>


                    <div class="qty-label">

                        No.

                    </div>


                </td>


                <!-- AMOUNT -->

                <td class="amount">


                    <strong>

                        ₹ <?= number_format(
                            $subtotal,
                            2,
                            '.',
                            ','
                        ); ?>

                    </strong>


                </td>


            </tr>


        </tbody>


    </table>


    <!-- ======================================================
         TOTALS
    ======================================================= -->

    <div class="totals-wrapper">


        <div class="totals">


            <!-- GST -->

            <div class="total-row">


                <span class="total-label">

                    GST 18%

                </span>


                <span class="total-value">

                    ₹ <?= number_format(
                        $gst,
                        2,
                        '.',
                        ','
                    ); ?>

                </span>


            </div>


            <!-- GRAND TOTAL -->

            <div class="grand-total">


                <span>
                    TOTAL
                </span>


                <span>

                    ₹ <?= number_format(
                        $grandTotal,
                        2,
                        '.',
                        ','
                    ); ?>

                </span>


            </div>


        </div>


    </div>


    <!-- ======================================================
         CONTINUED
    ======================================================= -->

    <div class="continued">

        <strong>
            Continued on next page...
        </strong>

    </div>


</div>



<!-- ==========================================================
     PAGE 2
========================================================== -->

<div class="quotation-page">


    <!-- ======================================================
         PRODUCT DETAILS
    ======================================================= -->

    <div class="section-title">

        Product Details

    </div>


    <?php if (!empty($imageLocation)): ?>


        <div class="product-image-box">


            <img
                src="<?= base_url(
                    'public/dist/img/' . $imageLocation
                ); ?>"
                alt="<?= esc($itemName); ?>"
            >


            <div class="product-image-name">

                <?= esc($itemName); ?>

            </div>


        </div>


    <?php endif; ?>


    <!-- ======================================================
         TERMS & CONDITIONS
    ======================================================= -->

    <div class="terms">


        <div class="section-title">

            Terms & Conditions

        </div>


        <p contenteditable>

            <strong>A.</strong>

            Above prices are Ex-Works Ahmedabad.
            Transportation charges are extra.

        </p>


        <p contenteditable>

            <strong>B. Payment Terms:</strong>

            50% Advance along with confirmed P.O. and balance
            50% against Proforma Invoice before dispatch after
            inspection.

        </p>


        <p contenteditable>

            <strong>C. Delivery:</strong>

            Within 3–4 weeks from the date of receipt of confirmed
            P.O. along with advance.

        </p>


        <p contenteditable>

            <strong>D. Installation:</strong>

            Installation will be provided free of cost from our side.

        </p>


        <p contenteditable>

            <strong>E.</strong>

            The design and prices are subject to change for any
            changes/additions in the above specifications.

        </p>


        <p contenteditable>

            <strong>F. Warranty:</strong>

            1 year from the date of delivery against manufacturing
            defects. The warranty covers free replacement of
            defective parts, if any.

        </p>


        <p contenteditable>

            <strong>G.</strong>

            Order once placed cannot be cancelled under any
            circumstances. In case of cancellation, the entire
            amount of advance payment will stand forfeited.

        </p>


    </div>



    <!-- ======================================================
         BANK DETAILS
    ======================================================= -->

    <div class="bank-section">


        <div class="section-title">

            Bank Details

        </div>


        <div class="bank-grid">


            <?php foreach ($bankDetails as $bank): ?>


                <div class="bank-card">


                    <div>

                        <span class="bank-label">
                            Account Name:
                        </span>

                        Codetech Engineers

                    </div>


                    <div class="bank-name">

                        <span class="bank-label">
                            Bank Name:
                        </span>

                        <?= esc($bank['bname']); ?>

                    </div>


                    <div>

                        <span class="bank-label">
                            A/C No:
                        </span>

                        <?= esc($bank['ac']); ?>

                    </div>


                    <div>

                        <span class="bank-label">
                            IFSC:
                        </span>

                        <?= esc($bank['ifsc']); ?>

                    </div>


                    <div>

                        <span class="bank-label">
                            Branch:
                        </span>

                        <?= esc($bank['branch']); ?>

                    </div>


                </div>


            <?php endforeach; ?>


        </div>


    </div>



    <!-- ======================================================
         CLOSING
    ======================================================= -->

    <div class="closing">


        <p>

            We hope that the offer is technically in line
            with your requirement.

        </p>


        <p>

            Thanking you and looking forward to receiving your
            valuable Purchase Order.

        </p>


    </div>



    <!-- ======================================================
         SIGNATURE
    ======================================================= -->

    <div class="signature">


        <div>

            Yours truly,

        </div>


        <div style="margin-top:15px;">

            <strong>
                From CodeTech Engineers
            </strong>

        </div>


        <div class="signature-line">

            -----sd------

        </div>


        <div class="signature-name">


            Kamlesh Chavda


            <span class="mobile">

                Mob.: +91-9737693302

            </span>


        </div>


    </div>


</div>



<script>

    var base_url = "<?= base_url(); ?>";

</script>


</body>

</html>