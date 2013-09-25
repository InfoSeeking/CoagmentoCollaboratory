#Questions
- what are the following: loopStage, synchStage, and allowBrowsing?

#Some Considerations
- The User/Project class does not have methods for updating/deleting current records, do we want that?
- Where do I store stuff in session? On login?
- How do you get local time?
- Right now, storing user id in session, should I avoid this for security?

#Actions:
user_state:
	login
	logout
	create
	delete
	password_change


#TODO
- Classes should not depend on session values, so do not read user id from session
- (From Roberto) userID should be added as session variable outside the context of the class User
- Remove the getters/setters from the session class, this class is up to whoever is implementing it
- add [blank] classes for roles, persmisions, and study