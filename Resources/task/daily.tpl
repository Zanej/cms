<div class="container">
	{foreach $days as $k => $v}
		<div class="day" data-date ="{$k}">
			<div class="day_text">
				{$v.name}
			</div>

			{if count($v.tasks) > 0}
				<ul>
				{foreach $v.tasks as $kt => $t}
					<li class='task'>
						<div class='profile'>
							<figure>
								<img src=''/>
							</figure>
						</div>
						<div class='text'>
							<span class='text_save'>
								{$t->getText()}
							</span>
							<div class="box_input">
								<div class="cont_input">
									<textarea name="text_{$k}_{$t->getId()}" disabled>{$t->getText()}</textarea>		
								</div>
							</div>							
						</div>					
					</li>
				{/foreach}
				</ul>
			{/if}
			<div class='add'>
				<div class='profile'>
					<figure>
						<img src=''/>
					</figure>
				</div>
				<div class='text'>
					<div class="box_input">
						<div class="cont_input">
							<textarea name="text_add_{$k}"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	{/foreach}
</div>