<!-- ADD NEW GROUP POPUP  -->

<div id="add_group" class="modal custom-modal fade center-modal" role="dialog">
	<div class="modal-dialog">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Create a group</h3>
			</div>
			<div class="modal-body">
				<p>Groups are where your team communicates. They’re best when organized around a topic — #leads, for example.</p>
				<form id="text_group_form" method="post">
					<div class="form-group">
						<label>Group Name <span class="text-danger">*</span></label>
						<input class="form-control"  type="text" name="group_name" id="group_name">
					</div>
					<div class="form-group">
						<label>Send invites to: <span class="text-muted-light"></span></label>
						<input class="form-control"  type="text" name="members" id="members">
					</div>
					<div class="m-t-50 text-center">
						<button class="btn btn-primary btn-lg" type="submit" >Create Group</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- ADD NEW USER POPUP  -->
<div id="add_chat_user" class="modal custom-modal fade center-modal" role="dialog">
	<div class="modal-dialog">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Direct Chat</h3>
			</div>
			<div class="modal-body">
				<div class="input-group m-b-30">
					<input placeholder="Search to start a chat" class="form-control search-input input-lg" id="search_user" type="text">
					<span class="input-group-btn">
						<button class="btn btn-primary btn-lg" onclick="search_user()">Search</button>
					</span>
				</div>
				<div>
					<h5>Recent Conversations</h5>
					<div id="user_list"></div>									
				</div>
			</div>
		</div>
	</div>
</div>

<!-- INCOMING AUDIO CALL POPUP -->
<div id="incoming_call" class="modal custom-modal fade center-modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="profile-widget">
					<div class="profile-img">
						<a href="client-profile.html" class="avatar"><img src="assets/img/user-03.jpg" alt=""></a>
					</div>
					<h4 class="user-name m-t-10 m-b-0 text-ellipsis"><a href="client-profile.html">Tressa Wexler</a></h4>
					<div class="small text-muted">calling ...</div>
					<div class="incoming-btns">
						<a href="javascript:void(0)" class="btn btn-success m-r-10">Answer</a>
						<a href="javascript:void(0)" class="btn btn-danger" data-dismiss="modal">Decline</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>