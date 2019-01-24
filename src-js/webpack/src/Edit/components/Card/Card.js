/**
 * Components: Card.
 *
 * @since 3.21.0
 */

/**
 * External dependencies
 */
import { Article, Header } from '..';

const Card = ({
	title,
	text,
	data
}) => (
	<Article type="card">
	<Header>
		<h5>{title}</h5>
		
	</Header>
	{text}
	
	</Article>
);

export default Card;