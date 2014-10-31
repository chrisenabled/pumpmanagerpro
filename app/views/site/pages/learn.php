<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Learn';
Yii::app()->clientScript->registerScript(
    'myScrollEffect',
    "
    $(window).scroll(function() {
    var navigator = $('#navigator'),
        targetScroll = $('#styledDiv').position().top,
        currentScroll = $('html').scrollTop() || $('body').scrollTop();

    navigator.toggleClass('fixedPos', currentScroll >= targetScroll);

    });

    ",
    CClientScript::POS_READY
);
?>

    <div class="hero-unit" id="btlearnhero">
        <h1 id="tutorial">PMP Guide</h1>
        <p>How to Manage your Station online...</p>
    </div>

<div class="row-fluid" style="margin-top: 60px; padding-bottom: 100px;">
    <div id="styledDiv">
    <div class="span3 well" id="navigator" style="margin-left: 20px;">
        <?php echo TbHtml::navList(array(
            array('label'=>'GETTING STARTED', 'itemOptions'=>array('class'=>'nav-header')),
            array('label'=>'Create an account', 'url'=>'#register'),
            array('label'=>'Set up your station', 'url'=>'#setup'),
            array('label'=>'Recording', 'url'=>'#recording'),
            TbHtml::menuDivider(),
            array('label'=>'SUMMARIES', 'itemOptions'=>array('class'=>'nav-header')),
            array('label'=>'Summary Containers', 'url'=>'#summary'),
            TbHtml::menuDivider(),
            array('label'=>'ACCOUNTS', 'itemOptions'=>array('class'=>'nav-header')),
            array('label'=>'Administrator', 'url'=>'#administrator'),
            array('label'=>'Personnel', 'url'=>'#personnel'),
            array('label'=>'Reader', 'url'=>'#reader'),
            TbHtml::menuDivider(),
            array('label'=>'MISCELLANEOUS', 'itemOptions'=>array('class'=>'nav-header')),
            array('label'=>'Filters', 'url'=>'#filters'),
            array('label'=>'Roll Back', 'url'=>'#rollback'),
            array('label'=>'Daily Data Feeds', 'url'=>'#feeds'),
            array('label'=>'Board', 'url'=>'#board'),
            array('label'=>'Updating Profile', 'url'=>'#profile'),
            array('label'=>'Handling secondary accounts', 'url'=>'#sec.accts'),
            array('label'=>'Custom Audit', 'url'=>'#audit'),
            TbHtml::menuDivider(),
            array('label'=>'Help', 'url'=>'#help'),
        )); ?>

    </div>
    </div>
    <div class="span8" id="learnbody">
        <div class="row-fluid">
            <div class="row-fluid"><h1>Getting Started</h1></div>
            <div class="span11 offset1">
                <h3 id="register">Create an account</h3>
                <div>
                    <p>
                        Click on any of the <code>create account</code> or <code>register</code> button/link on the
                        home page or any of the pages and fill out the form to your right. After filling,
                        click on the next step button to go to the next step. Sign in with your new credentials to start
                        managing your online station or browse round pages to acquaint yourself more about
                        pump manager pro.
                    </p>
                </div>
                <h3 id="setup">Set up your station</h3>
                <div>
                    <p>
                        When logged in, from the homepage or any of the pages click on panel to go to the control center where all tasks
                        are performed. To the right is a list of operations. Click on any item on the list to configure
                        ( <code>view</code>,<code>create</code>,<code>edit</code> or <code>delete 'if applicable'</code> )
                        the item. Start by creating items for your station.You must create attendants, stocks, tanks,
                        and pumps to have the minimum requirement for a working system.
                    </p>
                    <p class="offset1">
                        <span class="label label-important">important !</span> The order of creating
                        the items should be <strong>attendant->stock->tank->pump</strong>.
                    </p>
                    <p>
                        Because the system
                        models a real life operation of a filling station, it wouldn't allow you to create these items
                        in any arbitrary order, other than the one specified above with the exception of attendant coming first.
                        The reason for this forced order is obviously to make sure that errors, confusions and mistakes
                        are nullified during your station set up. Items <strong>invoice and expenditure</strong> are
                        used to check loopholes, losses and some other subtle issues that may be hard to notice in real
                        life handling. This items are best included after initial setup of your station and when records
                        are been inputted.
                    </p>
                    <p class="offset1"><span class="label label-info">note :</span> To have the best and accurate
                        result from your online management always record every invoice you have and expenses you make from stocks revenue. The system
                        uses the expenditure to calculate your finances. You on the order hand will use the invoice records
                        to see where you may be having shortages in your products.
                    </p>
                    <p>
                        The process of creating items have been made simple, intuitive and user friendly.
                    </p>
                </div>
                <h3 id="recording">Recording</h3>
                <div>
                    <p>
                        To record data for any of the item, click on the item from the operations list in the panel.
                        You will be presented with a grid table of all item lists. There are 3 icons to the right of each of
                        the items in the list. The <strong>view - update - delete(if applicable)</strong> icons respectively
                        in that order. To view the item, click on the view icon (left), to record data, click on the update icon
                        (center), to delete (if applicable), click on the delete icon (right).
                    </p>
                    <p>
                        <h5>Pump Reading</h5>
                        To take down pump readings, click on the pump item from the operations list in the panel. Then,
                        click the update icon of the particular pump you want to record readings for, on the pump table.
                        Fill out the fields <code>correctly</code> and click save. A confirmation prompt appears. Click ok
                        to proceed with saving the record or cancel to cross-check the fields.
                    </p>
                    <p>
                        <h5>Tank Quantity Update</h5>
                        To update stock quantity in a tank, click on the tank item from the operations list in the panel. Then,
                        click the update icon of the particular tank you want to update quantity, on the tank table.
                        Fill out the fields <code>correctly</code> and click save. A confirmation prompt appears. Click ok
                        to proceed with saving the record or cancel to cross-check the fields.
                            <p class="offset1">
                                <span class="label label-info">note :</span> The <code>Discharge Date</code> refers to
                                the date the added amount which u currently input was discharged into the tank. Which is
                                what you probably think it is.
                            </p>
                    </p>
                    <p>
                        <h5>Stock Price Update</h5>
                        To update stock price, click on the stock item from the operations list in the panel. Then,
                        click the update icon of the particular stock you want to update price for, on the stock table.
                        Fill out the fields <code>correctly</code> and click save. A confirmation prompt appears. Click ok
                        to proceed with saving the record or cancel to cross-check the fields.
                    </p>
                    <p>
                        <h5>About recording Expenditure</h5>
                        <span class="label label-info">note :</span> PMP has a limit on expenditure that does
                        not permit you to record amount of expenses that is more than the revenue made on stocks for that day which
                        the expenses were made. This is because, PMP is an application mainly for the management of stock
                        related activities and does not consider other businesses or sales made outside of stocks. So it is
                        recommended that only the expenses made from the revenue gotten from stock sales should be recorded
                        as expenditure.
                    </p>
                    <p>
                        <h5>Best Practices</h5>
                        In order to have everything run smooth with less huddle, it is best to take records in the order
                        in which activities unfold. In a practical scenario, a lot of recording will be done with pump
                        readings and tank quantity updates. Changes in stock prices happens rarely. As said before your
                        online filling station is a simulation of what happens in real.
                    </p>
                </div>
            </div>
            <p class="pull-right"><a href="#tutorial">
                <span class="badge badge-warning"><i class="icon-arrow-up icon-white"></i>back to top</span>
            </a></p>
        </div>
        <div class="row-fluid"><h1 id="summary">Summaries</h1></div>
        <div class="span11 offset1">
            <h3>About Summary Containers</h3>
            <p>
                <img class="pull-left" src=<?php echo Yii::app()->request->baseUrl.'/images/yearly_summary.png' ?>  >
                As you enter data, Pump Manager Pro not only saves your data but also performs calculations with the data. It also extends
                some additional functionality with ease which are very time consuming and prone to errors
                when done in real. For example, audit. The system does an audit of the records and provides visuals in
                form of summaries. This summaries are seen on the panel page, and there are four of these summary views :
                <strong>Daily , Weekly, Monthly and Yearly</strong> summaries. These views contain short important information
                on stocks, invoices, expenditures and finances. The daily summary container, contains summary for the current day.
                The weekly summary contains summary for the current week which stems from monday to sunday. Monthly
                summary has records for the present month, while yearly summary accumulates all the records for d year or
                as the year may not have rolled out, it contains the cumulative from the beginning of the year up to the
                present day.
            </p>
            <br style="clear: both" >
            <p class="pull-right"><a href="#tutorial">
                <span class="badge badge-warning"><i class="icon-arrow-up icon-white"></i>back to top</span>
            </a></p>
        </div>
        <div class="row-fluid"><h1>Accounts</h1></div>
        <div class="span11 offset1">
            <p>
                An online station has up to 3 different accounts with different authorization levels. This can be seen
                as a way to divide tasks among employees and also to provide some level of application security.
            </p>
            <h3 id="administrator">Administrator</h3>
            <p>
               When you first register an account, that account is known as the administrator account. The administrator is
                granted the maximum privileges. Administrator can create, edit, delete, and perform some actions
                which may not be permissible to the other accounts. Administrator is also responsible for creating the
                other accounts.
            </p>
            <h3 id="personnel">Personnel</h3>
            <p>
                The personnel account is the second in hierarchy. Personnel can edit items. Creation and deletion of some items
                are restricted to the personnel. Personnel has the privilege to create an attendant, invoice and expenditure.
            </p>
            <h3 id="reader">Reader</h3>
            <p>
                Reader has the least privilege. The Reader account can only be used to view items and navigate pages
                visible only to logged in users. All other privileges are restricted.
            </p>
            <h5>Best Practices</h5>
            <p>
                It is good practice to make full use of the 3 accounts to encourage productivity and division of labor.
                The administrator account could be given to a top manager, whose job is to oversee activities.
                The personnel account could be assigned to an employee who is given the task of recording data. The reader
                account should be handed to the dealer or a sales rep. and other persons who is in control of management.
            </p>

            <p class="pull-right"><a href="#tutorial">
                <span class="badge badge-warning"><i class="icon-arrow-up icon-white"></i>back to top</span>
            </a></p>
        </div>
        <div class="row-fluid"><h1 id="misc">Miscellaneous</h1></div>
        <div>
            <h3 id="filters">Filters</h3>
            <p>
                When performing search on tables, you can filter your search for a streamlined result. There are text
                fields at the top of every column on a table. This text fields are used to search results corresponding
                to the text you write on them. Your search criteria should be text that correspond to inputs on that
                particular column. The system automatically searches as you type or select a search criteria,
                if it doesn't, simply press the <code>enter key</code> on your keyboard.
            </p>
            <p class="offset1">
                <span class="label label-info">note :</span> Not all filter fields are functional, but filters which are
                necessary pertaining to likely searchable criteria are operational.
            </p>
            <h5>Multiple Search</h5>
            <p>
                You can write or select multiple search criteria than span more than one search field. As you type or select on
                each of your desired search fields, the system automatically pulls items that pass the aggregate of the search
                criteria.
            </p>
            <h3 id="rollback">Roll Back</h3>
            <p>
                You must be signed in as an administrator to use the <code>roll back</code> button. The button
                is a large back-arrow icon located at the bottom right of the panel view. When clicked, the button rolls back
                all records to the beginning of the day, i.e it deletes all records that have been inputted on the current
                day and returns the state of the system to before inputs where made on that day. This button can be seen
                as a safety button. Because for every input, the system does some background calculation which changes
                the state of the system, Pump Manager Pro does not permit some individual re-editing or deleting of already inputted
                data. But since mistakes are bound to be made, the system provides a last resort if any mistake must have
                been made and no other way of correction.
            </p>
            <h3 id="feeds">Daily Data Feeds</h3>
            <p>
                There is a feeds icon that appears once data have been saved. This icon appears on the top left of
                pages that are only visible to logged in users. Clicking this icon brings out the <code>data feeds</code> tablet
                from the side. The data feeds contains information on items that have been saved on the current day.
                This is a quick way of knowing actions that have recently been performed, even without having to
                navigate through pages.
            </p>
            <h3 id="board">The Board</h3>
            <p>
                Just like where details corresponding to an account can be viewed, the board is the view page for your
                station's account details. It contains the information of your station's contact info, stocks, attendants,
                pumps and tanks. Its a nice way of knowing your station's capacity.
            </p>
            <h3 id="profile">Updating Your Profile</h3>
            <p>
                As administrator, you can change your username, password, and station details. From the board page
                click on the update profile link to the right.
            </p>
            <h3 id="sec.accts">Handling secondary accounts</h3>
            <p>
                To create any of the secondary accounts, click on personnel or reader item on the operations list on the panel page.
                You can check recent activities on these accounts by clicking <code>users</code> on the
                navbar (administrators only). It shows you the name of the account and when last the account was logged in. You can also delete
                these accounts by clicking on the delete link to the right.
            </p>
            <h3 id="audit">Custom Audit</h3>
            <p>
                Pump Manager Pro Provides some audit information and displays them as summary containers but you can
                also perform some basic custom audit on some items. Click on stock from panel and then click on
                <code>Stock Stat</code>. This table contains stock statistics. This is a crucial information when
                performing audit in your real station. Below is a calculator for custom audit. You can select the date
                range for which the audit should be performed, then click calculate.
                Audit can also be performed on the invoice and expenditure items by following the same procedure.
            </p>

            <p class="pull-right"><a href="#tutorial">
                <span class="badge badge-warning"><i class="icon-arrow-up icon-white"></i>back to top</span>
            </a></p>
        </div>

    </div>
</div>