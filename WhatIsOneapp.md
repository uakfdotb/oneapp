# Introduction #

oneapp is a club application system design for schools to make the application and review processes simpler. It is released as free software under the GNU GPL v3.0.

First, oneapp moves applications online; this eliminates the need for paper and allows students to complete their applications at any location, at any time, with the least trouble.

Second, oneapp enables the possibility of smaller individual club applications. Instead, a single **general application** is submitted to all clubs, along with individual **supplements** for individual clubs. In this way, the redundancy on completing applications is reduced for the student, allowing students to engage in a larger amount of activities that they are interested in.

# Features #

Several features make oneapp powerful.

  * Security
    * All account passwords are hashed using the SHA-512 algorithm, making the original password almost impossible to retrieve should the database be compromised (we plan to add a salt for even greater security)
    * Support for an optional captcha system prevents automatic registration
    * Limits can be sent to prevent flooding of the database
  * Styles
    * The page views are separated from the processing, allowing for customizable styles
    * oneapp supports complete customization of the HTML by making styles collections of PHP functions that take in specific variables and output the view
    * Almost all interface functions are modifiable through styles
  * Statistics: advanced statistics options allow club administrators to quickly get an idea of the response distribution for survey questions
  * A simple question creator, along with a customizable advanced question creator, makes it both easy to get started with creating applications and possible to customize applications to specific needs
  * PDF generation: submissions are all converted using LaTeX to a PDF format to allow for a permanent record
    * Also, a blank application can be generated that allows users without a computer to fill out the application by hand
  * Recommendations: an email-based recommendation system makes it possible to require peer or teacher recommendations in club applications
  * Club notes: the club notes features allow you to better organize the evaluation of submissions by providing a textbox and category for filtering and a text box for storing comments