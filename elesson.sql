-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 05:50 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elesson`
--
CREATE DATABASE IF NOT EXISTS `elesson` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `elesson`;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `taskid` int(11) NOT NULL AUTO_INCREMENT,
  `taskname` varchar(99) NOT NULL,
  `taskdate` date NOT NULL,
  PRIMARY KEY (`taskid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`taskid`, `taskname`, `taskdate`) VALUES
(81, '<p>Server maintenance on <strong>6 Dec 2014</strong></p>\r\n', '2014-12-03'),
(82, '<p>Server down time <strong>15Dec2014 6.00 P.M. to 8 P.M.</strong></p>\r\n', '2014-12-03'),
(83, '<p>Today is a shining day.</p>\r\n', '2014-12-04');

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE IF NOT EXISTS `choice` (
  `choiceid` int(11) NOT NULL AUTO_INCREMENT,
  `questionid` int(11) DEFAULT '0',
  `choicecontent` varchar(100) NOT NULL,
  `isdefault` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`choiceid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` int(11) NOT NULL AUTO_INCREMENT,
  `coursename` varchar(100) NOT NULL,
  `created` date NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`courseid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `coursename`, `created`, `description`) VALUES
(1, 'IT ', '2014-11-02', 'This is an IT course. '),
(3, 'Accounting', '2014-11-09', 'This is an accounting course'),
(4, 'Mechanical', '2014-11-09', 'This is a mechanical course'),
(5, 'Civil', '2014-11-09', 'This is a civil course'),
(6, 'Chemical', '2014-11-13', 'This is chemical course'),
(7, 'Physic', '2014-11-13', 'This is XXXXX'),
(9, 'Human Resource', '2014-11-13', 'XXXXXXX'),
(10, 'Biology', '2014-12-03', 'This is Biology Course'),
(11, 'Moral', '2014-12-03', 'This is moral course'),
(12, 'History', '2014-12-03', 'This is history Course');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `emailid` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`emailid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`emailid`, `date`, `receiver`, `message`) VALUES
(1, '2015-04-13 09:58:27', 'user@hotmail.com', 'Hello, this is a gentle reminder to inform you still have uncompleted lesson,  [ IT Lesson 1 = Last view on 0 days ago ] [ IT Lesson 2 = Last view on 5 days ago ]. This is an auto-generated email, please do not reply.');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `lessonid` int(11) NOT NULL AUTO_INCREMENT,
  `lessonname` varchar(200) NOT NULL,
  `created` date NOT NULL,
  `lessoncontent` text NOT NULL,
  `direction_id` int(11) NOT NULL,
  PRIMARY KEY (`lessonid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`lessonid`, `lessonname`, `created`, `lessoncontent`, `direction_id`) VALUES
(1, 'HTML', '2014-11-23', '<h1>HTML&nbsp;Basic Examples</h1>\r\n\r\n<hr />\r\n<h2>HTML Documents</h2>\r\n\r\n<p>All HTML documents must start with a type declaration:&nbsp;<strong>&lt;!DOCTYPE html&gt;</strong>.</p>\r\n\r\n<p>The HTML document itself begins with&nbsp;<strong>&lt;html&gt;</strong>&nbsp;and ends with&nbsp;<strong>&lt;/html&gt;</strong>.</p>\r\n\r\n<p>The visible part of the HTML document is between&nbsp;<strong>&lt;body&gt;</strong>&nbsp;and&nbsp;<strong>&lt;/body&gt;</strong>.</p>\r\n\r\n<h2>Example</h2>\r\n\r\n<p>&lt;!DOCTYPE&nbsp;html&gt;<br />\r\n&lt;html&gt;<br />\r\n&lt;body&gt;<br />\r\n<br />\r\n&lt;h1&gt;My First Heading&lt;/h1&gt;<br />\r\n<br />\r\n&lt;p&gt;My first paragraph.&lt;/p&gt;<br />\r\n<br />\r\n&lt;/body&gt;<br />\r\n&lt;/html&gt;</p>\r\n\r\n<p><br />\r\n<a href="http://www.w3schools.com/html/tryit.asp?filename=tryhtml_basic_document" target="_blank">Try it Yourself &raquo;</a></p>\r\n', 1),
(2, 'SQL', '2014-11-23', '<p>SQL is a standard language for accessing and manipulating databases.</p>\r\n\r\n<hr />\r\n<h2>What is SQL?</h2>\r\n\r\n<ul>\r\n	<li>SQL stands for Structured Query Language</li>\r\n	<li>SQL lets you access and manipulate databases</li>\r\n	<li>SQL is an ANSI (American National Standards Institute) standard</li>\r\n</ul>\r\n\r\n<hr />\r\n<h2>What Can SQL do?</h2>\r\n\r\n<ul>\r\n	<li>SQL can execute queries against a database</li>\r\n	<li>SQL can retrieve data from a database</li>\r\n	<li>SQL can insert records in a database</li>\r\n	<li>SQL can update records in a database</li>\r\n	<li>SQL can delete records from a database</li>\r\n	<li>SQL can create new databases</li>\r\n	<li>SQL can create new tables in a database</li>\r\n	<li>SQL can create stored procedures in a database</li>\r\n	<li>SQL can create views in a database</li>\r\n	<li>SQL can set permissions on tables, procedures, and views</li>\r\n</ul>\r\n\r\n<hr />\r\n<h2>SQL is a Standard - BUT....</h2>\r\n\r\n<p>Although SQL is an ANSI (American National Standards Institute) standard, there are different versions of the SQL language.</p>\r\n\r\n<p>However, to be compliant with the ANSI standard, they all support at least the major commands (such as SELECT, UPDATE, DELETE, INSERT, WHERE) in a similar manner.</p>\r\n\r\n<table style="width:888px">\r\n	<tbody>\r\n		<tr>\r\n			<th style="width:34px"><img alt="Note" src="http://www.w3schools.com/images/lamp.jpg" style="height:32px; width:32px" /></th>\r\n			<td><strong>Note:</strong>&nbsp;Most of the SQL database programs also have their own proprietary extensions in addition to the SQL standard!</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<hr />\r\n<h2>Using SQL in Your Web Site</h2>\r\n\r\n<p>To build a web site that shows data from a database, you will need:</p>\r\n\r\n<ul>\r\n	<li>An RDBMS database program (i.e. MS Access, SQL Server, MySQL)</li>\r\n	<li>To use a server-side scripting language, like PHP or ASP</li>\r\n	<li>To use SQL to get the data you want</li>\r\n	<li>To use HTML / CSS</li>\r\n</ul>\r\n', 1),
(3, 'Javascript', '2014-11-23', '<p>JavaScript is the most popular programming language in the world.</p>\r\n\r\n<p>This page contains some examples of what JavaScript can do.</p>\r\n\r\n<hr />\r\n<h2>JavaScript Can Change HTML Content</h2>\r\n\r\n<p>One of many HTML methods is&nbsp;<strong>getElementById()</strong>.</p>\r\n\r\n<p>This example uses the method to &quot;find&quot; an HTML element (with id=&quot;demo&quot;<strong>)</strong>, and changes the element content (<strong>innerHTML</strong>) to &quot;Hello JavaScript&quot;:</p>\r\n\r\n<h2>Example</h2>\r\n\r\n<p>document.getElementById(&quot;demo&quot;).innerHTML =&nbsp;&quot;Hello JavaScript&quot;;</p>\r\n\r\n<p><br />\r\n<a href="http://www.w3schools.com/js/tryit.asp?filename=tryjs_intro_inner_html" target="_blank">Try it Yourself &raquo;</a></p>\r\n\r\n<hr />\r\n<h2>JavaScript Can Change HTML Attributes</h2>\r\n\r\n<p>This example changes an HTML image, by changing the src attribute of an &lt;img&gt; tag:</p>\r\n\r\n<h2>The Light bulb</h2>\r\n\r\n<p><img src="http://www.w3schools.com/js/pic_bulboff.gif" style="height:180px; width:100px" /></p>\r\n\r\n<p>Click the light bulb to turn on/off the light</p>\r\n\r\n<p><br />\r\n<a href="http://www.w3schools.com/js/tryit.asp?filename=tryjs_intro_lightbulb" target="_blank">Try it Yourself &raquo;</a></p>\r\n\r\n<hr />\r\n<h2>JavaScript Can Change HTML Styles (CSS)</h2>\r\n\r\n<p>Changing the style of an HTML element, is a variant of changing an HTML attribute:</p>\r\n\r\n<h2>Example</h2>\r\n\r\n<p>document.getElementById(&quot;demo&quot;).style.fontSize =&nbsp;&quot;25px&quot;;</p>\r\n\r\n<p><br />\r\n<a href="http://www.w3schools.com/js/tryit.asp?filename=tryjs_intro_style" target="_blank">Try it Yourself &raquo;</a></p>\r\n\r\n<hr />\r\n<h2>JavaScript Can Validate Data</h2>\r\n\r\n<p>JavaScript is often used to validate input:</p>\r\n\r\n<p>Please input a number between 1 and 10</p>\r\n\r\n<p>&nbsp;Submit</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><br />\r\n<a href="http://www.w3schools.com/js/tryit.asp?filename=tryjs_intro_validate" target="_blank">Try it Yourself &raquo;</a></p>\r\n', 1),
(4, 'Business Lesson 1', '2014-11-23', '<p><strong>You may think your product is perfect, but your clients won&rsquo;t.</strong>&nbsp;Listen to user feedback: Your opinion may not be the best one. The key takeaway here is &ldquo;release your product early and release it often.&rdquo; You won&rsquo;t know if you have a great product until it&rsquo;s in the field and users are beating it up. It&rsquo;s like some of the contestants on American Idol. They think they&rsquo;re talented, and their friends and family think so, too, but when they get on a bigger stage, their flaws become obvious.</p>\r\n', 2),
(5, 'Business Lesson 2', '2014-11-23', '<p><strong>Patience and flexibility help you survive the lean times.&nbsp;</strong>ShortStack started out as a side project at my web and graphic design studio. We weren&rsquo;t a software development studio, but when a client asked us for a software product, we didn&rsquo;t say no. We were patient, scaled slowly &mdash; partly out of necessity &mdash; and it allowed me to build with company without debt.</p>\r\n', 2),
(6, 'Accounting Lesson 1', '2014-11-23', 'Blah Blah Blah', 3),
(7, 'CSS', '2014-11-23', '<h2>What You Should Already Know</h2>\r\n\r\n<p>Before you continue you should have a basic understanding of the following:</p>\r\n\r\n<ul>\r\n	<li>HTML</li>\r\n</ul>\r\n\r\n<p>If you want to study this subject first, find the tutorial on our&nbsp;<a href="http://www.w3schools.com/default.asp" target="_top">Home page</a>.</p>\r\n\r\n<hr />\r\n<h2>CSS Demo - One Page - Multiple Styles!</h2>\r\n\r\n<p>One HTML page displayed with different style sheets:&nbsp;<a href="http://www.w3schools.com/css/demo_default.htm" target="_blank">See how it works!</a></p>\r\n\r\n<hr />\r\n<h2>What is CSS?</h2>\r\n\r\n<ul>\r\n	<li><strong>CSS</strong>&nbsp;stands for&nbsp;<strong>C</strong>ascading&nbsp;<strong>S</strong>tyle&nbsp;<strong>S</strong>heets</li>\r\n	<li>CSS defines&nbsp;<strong>how HTML elements are to be displayed</strong></li>\r\n	<li>Styles were added to HTML 4.0&nbsp;<strong>to solve a problem</strong></li>\r\n	<li>CSS saves a lot of work</li>\r\n	<li>External Style Sheets are stored in&nbsp;<strong>CSS files</strong></li>\r\n</ul>\r\n\r\n<hr />\r\n<h2>CSS Solved a Big Problem</h2>\r\n\r\n<p>HTML was NEVER intended to contain tags for formatting a document.</p>\r\n\r\n<p>HTML was intended to&nbsp;<strong>define the content</strong>&nbsp;of a document, like:</p>\r\n\r\n<p>&lt;h1&gt;This is a heading&lt;/h1&gt;</p>\r\n\r\n<p>&lt;p&gt;This is a paragraph.&lt;/p&gt;</p>\r\n\r\n<p>When tags like &lt;font&gt;, and color attributes were added to the HTML 3.2 specification, it started a nightmare for web developers. Development of large web sites, where fonts and color information were added to every single page, became a long and expensive process.</p>\r\n\r\n<p>To solve this problem, the World Wide Web Consortium (W3C) created CSS.</p>\r\n\r\n<p>In HTML 4.0, all formatting could (and should!) be removed from the HTML document, and stored in a separate CSS file.</p>\r\n\r\n<hr />\r\n<h2>CSS Saves a Lot of Work!</h2>\r\n\r\n<p>The style definitions are normally saved in external .css files.</p>\r\n\r\n<p>With an external style sheet file, you can change the look of an entire Web site by changing just one file!</p>\r\n', 1),
(8, 'PHP', '2014-11-23', '<h2>What You Should Already Know</h2>\r\n\r\n<p>Before you continue you should have a basic understanding of the following:</p>\r\n\r\n<ul>\r\n	<li>HTML</li>\r\n	<li>CSS</li>\r\n	<li>JavaScript</li>\r\n</ul>\r\n\r\n<p>If you want to study these subjects first, find the tutorials on our&nbsp;<a href="http://www.w3schools.com/default.asp">Home page</a>.</p>\r\n\r\n<hr />\r\n<h2>What is PHP?</h2>\r\n\r\n<ul>\r\n	<li>PHP is an acronym for &quot;PHP: Hypertext Preprocessor&quot;</li>\r\n	<li>PHP is a widely-used, open source scripting language</li>\r\n	<li>PHP scripts are executed on the server</li>\r\n	<li>PHP is free to download and use</li>\r\n</ul>\r\n\r\n<table style="width:888px">\r\n	<tbody>\r\n		<tr>\r\n			<th style="width:34px"><img alt="Note" src="http://www.w3schools.com/images/lamp.jpg" style="height:32px; width:32px" /></th>\r\n			<td><strong>PHP is an amazing and popular language!</strong><br />\r\n			<br />\r\n			It is powerful enough to be at the core of the biggest blogging system on the web (WordPress)!<br />\r\n			It is deep enough to run the largest social network (Facebook)!<br />\r\n			It is also easy enough to be a beginner&#39;s first server side language!</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<hr />\r\n<h2>What is a PHP File?</h2>\r\n\r\n<ul>\r\n	<li>PHP files can contain text, HTML, CSS, JavaScript, and PHP code</li>\r\n	<li>PHP code are executed on the server, and the result is returned to the browser as plain HTML</li>\r\n	<li>PHP files have extension &quot;.php&quot;</li>\r\n</ul>\r\n\r\n<hr />\r\n<h2>What Can PHP Do?</h2>\r\n\r\n<ul>\r\n	<li>PHP can generate dynamic page content</li>\r\n	<li>PHP can create, open, read, write, delete, and close files on the server</li>\r\n	<li>PHP can collect form data</li>\r\n	<li>PHP can send and receive cookies</li>\r\n	<li>PHP can add, delete, modify data in your database</li>\r\n	<li>PHP can be used to control user-access</li>\r\n	<li>PHP can encrypt data</li>\r\n</ul>\r\n\r\n<p>With PHP you are not limited to output HTML. You can output images, PDF files, and even Flash movies. You can also output any text, such as XHTML and XML.</p>\r\n\r\n<hr />\r\n<h2>Why PHP?</h2>\r\n\r\n<ul>\r\n	<li>PHP runs on various platforms (Windows, Linux, Unix, Mac OS X, etc.)</li>\r\n	<li>PHP is compatible with almost all servers used today (Apache, IIS, etc.)</li>\r\n	<li>PHP supports a wide range of databases</li>\r\n	<li>PHP is free. Download it from the official PHP resource:&nbsp;<a href="http://www.php.net/" target="_blank">www.php.net</a></li>\r\n	<li>PHP is easy to learn and runs efficiently on the server side</li>\r\n</ul>\r\n', 1),
(9, 'C Language', '2014-11-23', '<p>C is a general-purpose high level language that was originally developed by Dennis Ritchie for the Unix operating system. It was first implemented on the Digital Eqquipment Corporation PDP-11 computer in 1972.</p>\r\n\r\n<p>The Unix operating system and virtually all Unix applications are written in the C language. C has now become a widely used professional language for various reasons.</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Easy to learn</p>\r\n	</li>\r\n	<li>\r\n	<p>Structured language</p>\r\n	</li>\r\n	<li>\r\n	<p>It produces efficient programs.</p>\r\n	</li>\r\n	<li>\r\n	<p>It can handle low-level activities.</p>\r\n	</li>\r\n	<li>\r\n	<p>It can be compiled on a variety of computers.</p>\r\n	</li>\r\n</ul>\r\n\r\n<h2>Facts about C</h2>\r\n\r\n<ul>\r\n	<li>\r\n	<p>C was invented to write an operating system called UNIX.</p>\r\n	</li>\r\n	<li>\r\n	<p>C is a successor of B language which was introduced around 1970</p>\r\n	</li>\r\n	<li>\r\n	<p>The language was formalized in 1988 by the American National Standard Institue (ANSI).</p>\r\n	</li>\r\n	<li>\r\n	<p>By 1973 UNIX OS almost totally written in C.</p>\r\n	</li>\r\n	<li>\r\n	<p>Today C is the most widely used System Programming Language.</p>\r\n	</li>\r\n	<li>\r\n	<p>Most of the state of the art software have been implemented using C</p>\r\n	</li>\r\n</ul>\r\n\r\n<h2>Why to use C ?</h2>\r\n\r\n<p>C was initially used for system development work, in particular the programs that make-up the operating system. C was adoped as a system development language because it produces code that runs nearly as fast as code written in assembly language. Some examples of the use of C might be:</p>\r\n\r\n<ul>\r\n	<li>Operating Systems</li>\r\n	<li>Language Compilers</li>\r\n	<li>Assemblers</li>\r\n	<li>Text Editors</li>\r\n	<li>Print Spoolers</li>\r\n	<li>Network Drivers</li>\r\n	<li>Modern Programs</li>\r\n	<li>Data Bases</li>\r\n	<li>Language Interpreters</li>\r\n	<li>Utilities</li>\r\n</ul>\r\n\r\n<h1>C Program File</h1>\r\n\r\n<p>All the C programs are writen into text files with extension &quot;.c&quot; for example&nbsp;<strong><em>hello.c</em></strong>. You can use &quot;vi&quot; editor to write your C program into a file.</p>\r\n\r\n<p>This tutorial assumes that you know how to edit a text file and how to write programming insturctions inside a program file.</p>\r\n\r\n<h1>C Compilers</h1>\r\n\r\n<p>When you write any program in C language then to run that program you need to compile that program using a C Compiler which converts your program into a language understandable by a computer. This is called machine language (ie. binary format). So before proceeding, make sure you have C Compiler available at your computer. It comes alongwith all flavors of Unix and Linux.</p>\r\n\r\n<p>If you are working over Unix or Linux then you can type&nbsp;<em>gcc -v</em>&nbsp;or&nbsp;<em>cc -v</em>&nbsp;and check the result. You can ask your system administrator or you can take help from anyone to identify an available C Compiler at your computer.</p>\r\n\r\n<p>If you don&#39;t have C compiler installed at your computer then you can use below given link to download a GNU C Compiler and use it.</p>\r\n\r\n<p>To know more about compilation you can go through this small tutorial&nbsp;<a href="http://www.tutorialspoint.com/makefile/index.htm">Learn Makefile</a>.</p>\r\n', 1),
(10, 'Accounting Lesson 2', '2014-11-23', '', 3),
(11, 'Mechanical Lesson 1', '2014-11-23', 'Blah Blah Blah', 4),
(18, 'Business Lesson 3', '2015-04-16', '<p><strong>You can&rsquo;t do everything on your own.</strong>&nbsp;Building a team is essential because there are only so many hours one person can devote to a business. Exactly when you reach that limit depends on your other obligations. If you&rsquo;re a young single person, you might be able to do everything for a year or two. But if you have a family, your dedication will eventually hurt those relationships. Build a team that can carry on when you&rsquo;re not around.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(19, 'C++ Language', '2015-04-16', '<p>&nbsp;C++ is a programming language--it will allow you to control your computer, making it do what you want it to do. This programming tutorial series is all about helping you take advantage of C++.</p>\r\n\r\n<h2>Getting Set Up - C++ Compilers</h2>\r\n\r\n<p>The very first thing you need to do, before starting out in C++, is to make sure that you have a compiler. What is a compiler, you ask? A compiler turns the program that you write into an&nbsp;<strong>executable</strong>&nbsp;that your computer can actually understand and run. If you&#39;re taking a course, you probably have one provided through your school. If you&#39;re starting out on your own, your best bet is to use&nbsp;<a href="http://www.cprogramming.com/code_blocks/">Code::Blocks with MinGW</a>. If you&#39;re on Linux, you can use<a href="http://www.cprogramming.com/g++.html">g++</a>, and if you&#39;re on Mac OS X, you can use&nbsp;<a href="http://www.cprogramming.com/xcode.html">XCode</a>. (If you are stuck using an older compiler, such as Turbo C++, you&#39;ll need to read this page on<a href="http://www.cprogramming.com/oldcpp.html">compatibility issues</a>.) If you haven&#39;t yet done so, go ahead and get a compiler set up--you&#39;ll need it for the rest of the tutorial.</p>\r\n\r\n<h2>Intro to the C++ Language</h2>\r\n\r\n<p>A C++ program is a collection of commands, which tell the computer to do &quot;something&quot;. This collection of commands is usually called&nbsp;<strong>C++ source code</strong>,&nbsp;<strong>source code</strong>&nbsp;or just&nbsp;<strong>code</strong>. Commands are either &quot;functions&quot; or &quot;keywords&quot;. Keywords are a basic building block of the language, while functions are, in fact, usually written in terms of simpler functions--you&#39;ll see this in our very first program, below. (Confused? Think of it a bit like an outline for a book; the outline might show every chapter in the book; each chapter might have its own outline, composed of sections. Each section might have its own outline, or it might have all of the details written up.) Thankfully, C++ provides a great many common functions and keywords that you can use.&nbsp;<br />\r\n<br />\r\nBut how does a program actually start? Every program in C++ has one function, always named&nbsp;<strong>main</strong>, that is always called when your program first executes. From main, you can also call other functions whether they are written by us or, as mentioned earlier, provided by the compiler.&nbsp;<br />\r\n<br />\r\nSo how do you get access to those prewritten functions? To access those standard functions that comes with the compiler, you include a header with the #include directive. What this does is effectively take everything in the header and paste it into your program. Let&#39;s look at a working program:</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n\r\n			<p>2</p>\r\n\r\n			<p>3</p>\r\n\r\n			<p>4</p>\r\n\r\n			<p>5</p>\r\n\r\n			<p>6</p>\r\n\r\n			<p>7</p>\r\n\r\n			<p>8</p>\r\n\r\n			<p>9</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:879px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>#include &lt;iostream&gt;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>using</code> <code>namespace</code> <code>std;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>int</code> <code>main()</code></p>\r\n\r\n			<p><code>{</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cout&lt;&lt;</code><code>&quot;HEY, you, I&#39;m alive! Oh, and Hello World!\n&quot;</code><code>;</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cin.get();</code></p>\r\n\r\n			<p><code>}</code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Let&#39;s look at the elements of the program. The #include is a &quot;preprocessor&quot; directive that tells the compiler to put code from the header called iostream into our program before actually creating the executable. By including header files, you gain access to many different functions. For example, the cout function requires iostream. Following the include is the statement, &quot;using namespace std;&quot;. This line tells the compiler to use a group of functions that are part of the standard library (std). By including this line at the top of a file, you allow the program to use functions such as cout. The semicolon is part of the syntax of C++. It tells the compiler that you&#39;re at the end of a command. You will see later that the semicolon is used to end most commands in C++.&nbsp;<br />\r\n<br />\r\nThe next important line is int main(). This line tells the compiler that there is a function named main, and that the function returns an integer, hence int. The &quot;curly braces&quot; ({ and }) signal the beginning and end of functions and other code blocks. You can think of them as meaning BEGIN and END.&nbsp;<br />\r\n<br />\r\nThe next line of the program may seem strange. If you have programmed in another language, you might expect that print would be the function used to display text. In C++, however, the cout object is used to display text (pronounced &quot;C out&quot;). It uses the &lt;&lt; symbols, known as &quot;insertion operators&quot;, to indicate what to output. cout&lt;&lt; results in a function call with the ensuing text as an argument to the function. The quotes tell the compiler that you want to output the literal string as-is. The &#39;\n&#39; sequence is actually treated as a single character that stands for a newline (we&#39;ll talk about this later in more detail). It moves the cursor on your screen to the next line. Again, notice the semicolon: it is added onto the end of most lines, such as function calls, in C++.&nbsp;<br />\r\n<br />\r\nThe next command is cin.get(). This is another function call: it reads in input and expects the user to hit the return key. Many compiler environments will open a new console window, run the program, and then close the window. This command keeps that window from closing because the program is not done yet because it waits for you to hit enter. Including that line gives you time to see the program run.&nbsp;<br />\r\n<br />\r\nUpon reaching the end of main, the closing brace, our program will return the value of 0 (and integer, hence why we told main to return an int) to the operating system. This return value is important as it can be used to tell the OS whether our program succeeded or not. A return value of 0 means success and is returned automatically (but only for main, other functions require you to manually return a value), but if we wanted to return something else, such as 1, we would have to do it with a return statement:</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n\r\n			<p>2</p>\r\n\r\n			<p>3</p>\r\n\r\n			<p>4</p>\r\n\r\n			<p>5</p>\r\n\r\n			<p>6</p>\r\n\r\n			<p>7</p>\r\n\r\n			<p>8</p>\r\n\r\n			<p>9</p>\r\n\r\n			<p>10</p>\r\n\r\n			<p>11</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:872px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>#include &lt;iostream&gt;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>using</code> <code>namespace</code> <code>std;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>int</code> <code>main()</code></p>\r\n\r\n			<p><code>{</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cout&lt;&lt;</code><code>&quot;HEY, you, I&#39;m alive! Oh, and Hello World!\n&quot;</code><code>;</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cin.get();</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>return</code> <code>1;</code></p>\r\n\r\n			<p><code>}</code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>The final brace closes off the function. You should try compiling this program and running it. You can cut and paste the code into a file, save it as a .cpp file. Our&nbsp;<a href="http://www.cprogramming.com/code_blocks/">Code::Blocks tutorial</a>&nbsp;actually takes you through creating a simple program, so check it out if you&#39;re confused.&nbsp;<br />\r\n<br />\r\nIf you are not using Code::Blocks, you should read the compiler instructions for information on how to compile.&nbsp;<br />\r\nOnce you&#39;ve got your first program running, why don&#39;t you try playing around with the cout function to get used to writing C++?<br />\r\n&nbsp;</p>\r\n\r\n<h2>An Aside on Commenting Your Programs</h2>\r\n\r\n<p>As you are learning to program, you should also start to learn how to explain your programs (for yourself, if no one else). You do this by adding comments to code; I&#39;ll use them frequently to help explain code examples.&nbsp;<br />\r\n<br />\r\nWhen you tell the compiler a section of text is a comment, it will ignore it when running the code, allowing you to use any text you want to describe the real code. To create a comment use either //, which tells the compiler that the rest of the line is a comment, or /* and then */ to block off everything between as a comment. Certain compiler environments will change the color of a commented area, but some will not. Be certain not to accidentally comment out code (that is, to tell the compiler part of your code is a comment) you need for the program. When you are learning to program, it is useful to be able to comment out sections of code in order to see how the output is affected.&nbsp;<br />\r\n&nbsp;</p>\r\n\r\n<h2>User interaction and Saving Information with Variables</h2>\r\n\r\n<p>So far you&#39;ve learned how to write a simple program to display information typed in by you, the programmer, and how to describe your program with comments. That&#39;s great, but what about interacting with your user? Fortunately, it is also possible for your program to accept input. The function you use is known as cin, and is followed by the extraction operator &gt;&gt;.&nbsp;<br />\r\n<br />\r\nOf course, before you try to receive input, you must have a place to store that input. In programming, input and data are stored in variables. There are several different types of variables which store different kinds of information (e.g. numbers versus letters); when you tell the compiler you are declaring a variable, you must include the data type along with the name of the variable. Several basic types include char, int, and float.&nbsp;<br />\r\n<br />\r\nA variable of type char stores a single character, variables of type int store integers (numbers without decimal places), and variables of type float store numbers with decimal places. Each of these variable types - char, int, and float - is each a keyword that you use when you&nbsp;<strong>declare</strong>&nbsp;a variable.</p>\r\n\r\n<h3>What&#39;s with all these variable types?</h3>\r\n\r\n<p>Sometimes it can be confusing to have multiple variable types when it seems like some variable types are redundant (why have integer numbers when you have floats?). Using the right variable type can be important for making your code readable and for efficiency--some variables require more memory than others. Moreover, because of the way the numbers are actually stored in memory, a float is &quot;inexact&quot;, and should not be used when you need to store an &quot;exact&quot; integer value.&nbsp;<br />\r\n&nbsp;</p>\r\n\r\n<h3>Declaring Variables in C++</h3>\r\n\r\n<p>To declare a variable you use the syntax &quot;type &lt;name&gt;;&quot;. Here are some variable declaration examples:</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n\r\n			<p>2</p>\r\n\r\n			<p>3</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:879px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>int</code> <code>x;</code></p>\r\n\r\n			<p><code>char</code> <code>letter;</code></p>\r\n\r\n			<p><code>float</code> <code>the_float;</code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>It is permissible to declare multiple variables of the same type on the same line; each one should be separated by a comma.</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:879px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>int</code> <code>a, b, c, d;</code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>If you were watching closely, you might have seen that declaration of a variable is always followed by a semicolon (note that this is the same procedure used when you call a function).</p>\r\n\r\n<p>Common Errors when Declaring Variables in C++</p>\r\n\r\n<p>If you attempt to use a variable that you have not declared, your program will not be compiled or run, and you will receive an error message informing you that you have made a mistake. Usually, this is called an&nbsp;<strong>undeclared variable</strong>.</p>\r\n\r\n<p>Case Sensitivity</p>\r\n\r\n<p>Now is a good time to talk about an important concept that can easily throw you off: case sensitivity. Basically, in C++, whether you use uppercase or lowercase letters matters. The words Cat and cat mean different things to the compiler. In C++, all language keywords, all functions and all variables are case sensitive. A difference in case between your variable declaration and the use of the variable is one reason you might get an undeclared variable error.</p>\r\n\r\n<h3>Using Variables</h3>\r\n\r\n<p>Ok, so you now know how to tell the compiler about variables, but what about using them?&nbsp;<br />\r\n<br />\r\nHere is a sample program demonstrating the use of a variable:</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n\r\n			<p>2</p>\r\n\r\n			<p>3</p>\r\n\r\n			<p>4</p>\r\n\r\n			<p>5</p>\r\n\r\n			<p>6</p>\r\n\r\n			<p>7</p>\r\n\r\n			<p>8</p>\r\n\r\n			<p>9</p>\r\n\r\n			<p>10</p>\r\n\r\n			<p>11</p>\r\n\r\n			<p>12</p>\r\n\r\n			<p>13</p>\r\n\r\n			<p>14</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:872px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>#include &lt;iostream&gt;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>using</code> <code>namespace</code> <code>std;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>int</code> <code>main()</code></p>\r\n\r\n			<p><code>{</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>int</code> <code>thisisanumber;</code></p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cout&lt;&lt;</code><code>&quot;Please enter a number: &quot;</code><code>;</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cin&gt;&gt; thisisanumber;</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cin.ignore();</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cout&lt;&lt;</code><code>&quot;You entered: &quot;</code><code>&lt;&lt; thisisanumber &lt;&lt;</code><code>&quot;\n&quot;</code><code>;</code></p>\r\n\r\n			<p><code>&nbsp;&nbsp;</code><code>cin.get();</code></p>\r\n\r\n			<p><code>}</code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Let&#39;s break apart this program and examine it line by line. The keyword int declares thisisanumber to be an integer. The function cin&gt;&gt; reads a value into thisisanumber; the user must press enter before the number is read by the program. cin.ignore() is another function that reads and discards a character. Remember that when you type input into a program, it takes the enter key too. We don&#39;t need this, so we throw it away. Keep in mind that the variable was declared an integer; if the user attempts to type in a decimal number, it will be truncated (that is, the decimal component of the number will be ignored). Try typing in a sequence of characters or a decimal number when you run the example program; the response will vary from input to input, but in no case is it particularly pretty. Notice that when printing out a variable quotation marks are not used. Were there quotation marks, the output would be &quot;You Entered: thisisanumber.&quot; The lack of quotation marks informs the compiler that there is a variable, and therefore that the program should check the value of the variable in order to replace the variable name with the variable when executing the output function. Do not be confused by the inclusion of two separate insertion operators on one line. Including multiple insertion operators on one line is perfectly acceptable and all of the output will go to the same place. In fact, you&nbsp;<strong>must</strong>&nbsp;separate string literals (strings enclosed in quotation marks) and variables by giving each its own insertion operators (&lt;&lt;). Trying to put two variables together with only one &lt;&lt; will give you an error message, do not try it. Do not forget to end functions and declarations with a semicolon. If you forget the semicolon, the compiler will give you an error message when you attempt to compile the program.</p>\r\n\r\n<p>Changing and Comparing Variables</p>\r\n\r\n<p>Of course, no matter what type you use, variables are uninteresting without the ability to modify them. Several operators used with variables include the following: *, -, +, /, =, ==, &gt;, &lt;. The * multiplies, the - subtracts, and the + adds. It is of course important to realize that to modify the value of a variable inside the program it is rather important to use the equal sign. In some languages, the equal sign compares the value of the left and right values, but in C++ == is used for that task. The equal sign is still extremely useful. It sets the left input to the equal sign, which must be one, and only one, variable equal to the value on the right side of the equal sign. The operators that perform mathematical functions should be used on the right side of an equal sign in order to assign the result to a variable on the left side.&nbsp;<br />\r\n<br />\r\nHere are a few examples:</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n\r\n			<p>2</p>\r\n\r\n			<p>3</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:879px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>a = 4 * 6; </code><code>// (Note use of comments and of semicolon) a is 24</code></p>\r\n\r\n			<p><code>a = a + 5; </code><code>// a equals the original value of a with five added to it</code></p>\r\n\r\n			<p><code>a == 5&nbsp;&nbsp;&nbsp;&nbsp; </code><code>// Does NOT assign five to a. Rather, it checks to see if a equals 5.</code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>The other form of equal, ==, is not a way to assign a value to a variable. Rather, it checks to see if the variables are equal. It is useful in other areas of C++; for example, you will often use == in such constructions as conditional statements and loops. You can probably guess how &lt; and &gt; function. They are greater than and less than operators.&nbsp;<br />\r\n<br />\r\nFor example:</p>\r\n\r\n<table border="0" cellpadding="0" cellspacing="0" style="height:auto !important; width:907px">\r\n	<tbody>\r\n		<tr>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:auto !important">\r\n			<p>1</p>\r\n\r\n			<p>2</p>\r\n\r\n			<p>3</p>\r\n			</td>\r\n			<td style="height:auto !important; vertical-align:baseline !important; width:879px">\r\n			<div style="background:none !important; border:0px !important; padding:0px !important">\r\n			<p><code>a &lt; 5&nbsp; </code><code>// Checks to see if a is less than five</code></p>\r\n\r\n			<p><code>a &gt; 5&nbsp; </code><code>// Checks to see if a is greater than five</code></p>\r\n\r\n			<p><code>a == 5 </code><code>// Checks to see if a equals five, for good measure </code></p>\r\n			</div>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><br />\r\n<br />\r\nYou might also be interested in these&nbsp;<a href="http://www.infiniteskills.com/training/learning-c-plus-plus.html?affid=k988">beginner C++ training videos</a>. We&#39;ve found these training videos to be an excellent way to master the fundamentals of C++ Programming. Taught by a Professor Mike McMillian, these training videos come with practical working files that allow you to learn at your own pace.&nbsp;<a href="http://www.infiniteskills.com/training/learning-c-plus-plus.html?affid=k988">Try a free demo today!</a>&nbsp;<br />\r\n<br />\r\n&nbsp;</p>\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lessonstatus`
--

CREATE TABLE IF NOT EXISTS `lessonstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `lessoncount` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `lessonstatus`
--

INSERT INTO `lessonstatus` (`id`, `userid`, `courseid`, `lessoncount`) VALUES
(1, 4, 1, 1),
(2, 4, 2, 1),
(5, 6, 1, 2),
(6, 6, 2, 1),
(7, 7, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `permitid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  PRIMARY KEY (`permitid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `questionid` int(11) NOT NULL AUTO_INCREMENT,
  `quizid` int(10) NOT NULL DEFAULT '0',
  `content` varchar(200) NOT NULL,
  `choicetype` enum('radio','checkbox','text','textarea') DEFAULT NULL,
  `answer` varchar(50) NOT NULL,
  `optionlist` varchar(200) NOT NULL,
  PRIMARY KEY (`questionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`questionid`, `quizid`, `content`, `choicetype`, `answer`, `optionlist`) VALUES
(12, 0, '<p>10 X 10 = ?</p>\r\n', 'radio', '100', '100/200/300/1000'),
(14, 0, '<p>1000 + 1000 = ?</p>\r\n', 'radio', '2000', '500/1000/2000/3000'),
(15, 0, '<p>500 divide&nbsp;100 equal to what?</p>\r\n', 'radio', '5', '1/3/5/7'),
(16, 0, '<p>If X = 1 and Y = 2. Then X + Y - 2 = ?</p>\r\n', 'radio', '1', '1/2/3/4'),
(17, 0, '<p>What IT stands for?</p>\r\n', 'radio', 'Information Technology', 'Information Technology/Informal Technician/Inline Text/Infinity Test'),
(18, 0, '<p>Which of the following is not an output device?&nbsp;</p>\r\n', 'radio', 'Pencil', 'KeyBoard/Printer/Monitor/Pencil'),
(19, 0, '<p>Which of the following is not a version of the Windows operating system software for the PC?</p>\r\n', 'radio', 'linux', '95/98/linux/ME'),
(20, 0, '<p>Which is the correct tag for HTML table?</p>\r\n', 'radio', 'table', 'table/div/input/a'),
(21, 0, '<p>What does HTML stand for?</p>\r\n', 'radio', 'Hyper Text Markup Language', 'Home Tool Markup Language/Hyperlinks and Text Markup Language/Hyper Text Markup Language'),
(22, 0, '<p>Choose the correct HTML tag for the largest heading?</p>\r\n', 'radio', 'h1', 'head/h1/h6/p'),
(23, 0, '<p>What is the correct HTML tag for inserting a line break?</p>\r\n', 'radio', 'br', 'br/bline/break'),
(24, 0, '<p>100+300 =?</p>\r\n', 'radio', '400', '400/100/500');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `quizid` int(11) NOT NULL AUTO_INCREMENT,
  `quizname` varchar(100) NOT NULL,
  `created` date NOT NULL,
  `lessonid` int(11) DEFAULT NULL,
  PRIMARY KEY (`quizid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quizid`, `quizname`, `created`, `lessonid`) VALUES
(1, 'IT Quiz 1', '2014-12-03', 1),
(2, 'IT Quiz 2', '2014-12-03', 2),
(3, 'Quiz 2', '2014-12-04', 3);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_to_question`
--

CREATE TABLE IF NOT EXISTS `quiz_to_question` (
  `quizid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_to_question`
--

INSERT INTO `quiz_to_question` (`quizid`, `questionid`) VALUES
(3, 17),
(3, 12),
(3, 14),
(3, 15),
(3, 16),
(4, 23),
(4, 22),
(4, 21),
(4, 20),
(4, 18),
(5, 24),
(5, 17),
(1, 17),
(1, 19),
(1, 20),
(1, 22),
(1, 23),
(2, 12),
(2, 14),
(2, 15);

-- --------------------------------------------------------

--
-- Table structure for table `setmark`
--

CREATE TABLE IF NOT EXISTS `setmark` (
  `radio` tinyint(5) NOT NULL DEFAULT '5',
  `checkbox` tinyint(5) NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(20) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0',
  `result` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `name`, `email`, `position`, `rank`, `result`) VALUES
(3, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 'jeffrey_ckh@hotmail.com', 'Manager', 1, 0),
(6, 'User', 'e10adc3949ba59abbe56e057f20f883e', 'User', 'user@hotmail.com', 'Staff', 3, 0),
(7, 'xia0t99', 'e10adc3949ba59abbe56e057f20f883e', 'Kit Loong', 'xia0t99@gmail.com', 'Normal Staff', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_to_lesson`
--

CREATE TABLE IF NOT EXISTS `user_to_lesson` (
  `utolid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `lessonid` int(11) NOT NULL,
  `viewtime` datetime NOT NULL,
  PRIMARY KEY (`utolid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `user_to_lesson`
--

INSERT INTO `user_to_lesson` (`utolid`, `userid`, `lessonid`, `viewtime`) VALUES
(1, 6, 2, '2015-04-20 14:23:28'),
(2, 6, 3, '2015-04-08 06:54:00'),
(3, 7, 2, '2015-04-08 09:02:33'),
(4, 6, 6, '2015-04-15 20:24:45'),
(5, 6, 1, '2015-04-20 14:22:50'),
(6, 6, 1, '0000-00-00 00:00:00'),
(7, 6, 1, '0000-00-00 00:00:00'),
(8, 6, 3, '0000-00-00 00:00:00'),
(9, 6, 3, '0000-00-00 00:00:00'),
(10, 6, 1, '0000-00-00 00:00:00'),
(11, 6, 1, '0000-00-00 00:00:00'),
(12, 6, 1, '0000-00-00 00:00:00'),
(13, 6, 1, '0000-00-00 00:00:00'),
(14, 6, 1, '0000-00-00 00:00:00'),
(15, 6, 1, '0000-00-00 00:00:00'),
(16, 6, 1, '0000-00-00 00:00:00'),
(17, 7, 1, '0000-00-00 00:00:00'),
(18, 7, 1, '0000-00-00 00:00:00'),
(19, 6, 1, '0000-00-00 00:00:00'),
(20, 6, 1, '0000-00-00 00:00:00'),
(21, 6, 1, '0000-00-00 00:00:00'),
(22, 6, 1, '0000-00-00 00:00:00'),
(23, 6, 1, '0000-00-00 00:00:00'),
(24, 6, 1, '0000-00-00 00:00:00'),
(25, 6, 1, '0000-00-00 00:00:00'),
(26, 6, 1, '0000-00-00 00:00:00'),
(27, 6, 1, '0000-00-00 00:00:00'),
(28, 6, 1, '0000-00-00 00:00:00'),
(29, 6, 1, '0000-00-00 00:00:00'),
(30, 6, 1, '0000-00-00 00:00:00'),
(31, 6, 1, '0000-00-00 00:00:00'),
(32, 6, 1, '0000-00-00 00:00:00'),
(33, 6, 1, '0000-00-00 00:00:00'),
(34, 6, 1, '0000-00-00 00:00:00'),
(35, 6, 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_to_question`
--

CREATE TABLE IF NOT EXISTS `user_to_question` (
  `uqid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `quizid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `completed` int(11) NOT NULL,
  PRIMARY KEY (`uqid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `user_to_question`
--

INSERT INTO `user_to_question` (`uqid`, `userid`, `quizid`, `questionid`, `answer`, `completed`) VALUES
(1, 6, 3, 16, '1', 1),
(2, 6, 3, 17, 'Information Technology', 1),
(3, 6, 3, 14, '2000', 1),
(4, 6, 3, 12, '', 0),
(5, 6, 3, 17, '', 0),
(6, 6, 3, 16, '', 0),
(7, 6, 1, 23, 'br', 1),
(8, 6, 1, 17, 'Information Technology', 1),
(9, 6, 1, 20, 'table', 1),
(10, 6, 1, 20, 'table', 1),
(11, 6, 1, 17, 'Information Technology', 1),
(12, 6, 1, 19, '95', 1),
(13, 6, 1, 23, 'br', 1),
(14, 6, 1, 22, 'head', 1),
(15, 6, 1, 19, '95', 1),
(16, 7, 1, 20, '<table>', 1),
(17, 7, 1, 17, 'Information Technology', 1),
(18, 7, 1, 19, '98', 1),
(19, 7, 3, 12, '100', 1),
(20, 7, 3, 16, '1', 1),
(21, 7, 3, 14, '500', 1),
(22, 7, 2, 15, '3', 1),
(23, 7, 2, 12, '200', 1),
(24, 7, 2, 14, '1000', 1),
(25, 7, 1, 23, '<br>', 1),
(26, 7, 1, 19, '98', 1),
(27, 7, 1, 22, '', 0),
(28, 7, 2, 12, '', 0),
(29, 7, 2, 15, '', 0),
(30, 7, 2, 14, '', 0),
(31, 6, 1, 19, '95', 1),
(32, 6, 1, 17, 'Information Technology', 1),
(33, 6, 1, 22, 'head', 1),
(34, 6, 1, 20, 'table', 1),
(35, 6, 1, 19, '95', 1),
(36, 6, 1, 23, 'br', 1),
(37, 6, 1, 22, 'head', 1),
(38, 6, 1, 19, '95', 1),
(39, 6, 1, 23, 'br', 1),
(40, 6, 1, 23, 'br', 1),
(41, 6, 1, 19, '95', 1),
(42, 6, 1, 22, 'head', 1),
(43, 6, 1, 20, 'table', 1),
(44, 6, 1, 17, 'Information Technology', 1),
(45, 6, 1, 19, '95', 1),
(46, 6, 1, 23, 'br', 1),
(47, 6, 1, 22, 'head', 1),
(48, 6, 1, 17, 'Information Technology', 1),
(49, 6, 1, 22, 'head', 1),
(50, 6, 1, 19, '95', 1),
(51, 6, 1, 17, 'Information Technology', 1),
(52, 6, 1, 23, 'br', 1),
(53, 6, 1, 17, 'Information Technology', 1),
(54, 6, 1, 19, '95', 1),
(55, 6, 1, 23, 'br', 1),
(56, 6, 1, 20, 'table', 1),
(57, 6, 1, 22, 'head', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
