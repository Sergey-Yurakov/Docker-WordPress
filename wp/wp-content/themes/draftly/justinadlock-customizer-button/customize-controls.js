( function( api ) {

	// Extends our custom "draftly" section.
	api.sectionConstructor['draftly'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
