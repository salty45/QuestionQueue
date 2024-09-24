<h1> CCLC Queue Server Code </h1>
<p>This is code written as a question queue for students to be able to ask questions and coaches to be able to answer them.  It was written to help ensure brief waiting times during the pandemic when the learning center moved online.</p>
A working version of the queue is available at <a href="https://pages.mtu.edu/~selarkin/cclc/queue.php">pages.mtu.edu/~selarkin/cclc/queue.php</a>

The queue should look something like this:<br>
<img src="https://pages.mtu.edu/~selarkin/cclc/queue_image.png" width="500" height="350" />

For a student to place a detailed comment with their question into the queue, the student needs to add a GET request into the header:  ?music=oboe

For a coach to be able to remove a question in the queue, the coach needs to add a GET request into the header: ?ilove=programming

While this isn't particularly secure, it was an easy step to having this easily accessible until it could be integrated with SSO on campus. Security wasn't the priority, since the information here is anonymous to start with.

<h3>Future Work</h3>
<ul>
  <li>Add pages for navigation bar links</li>
  <li>Modify beep</li>
  <li>Fix overflow on clock time for long-lasting questions (greater than several days) </li>
</ul>
