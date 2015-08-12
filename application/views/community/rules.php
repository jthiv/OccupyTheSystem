<?PHP
echo "<a href='".URL."community'><-Return to Communities Page</a>";

switch($this->section)
{
    case 'local':
        echo "<h2>Community: Local Section Rules and Etiquette</h2><hr>";
        echo "The local section is a section of threads is a subset of the \"Formal\" section. The same rules and etiquette apply.
        These threads will be made up of discussions about specific politicans, events, etc. You will only see politicians that directly
        represent you being discussed.";
        break;
    case 'general':
        echo "<h2>Community: General Section Rules and Etiquette</h2><hr>";
        echo "The casual section will be made of up categories that could extend to things like current events. Whereas the formal categories
        would be categorized by specific politicians, legislation, etc., the casual section will encompass larger topics. The etiquette will
        be less formal.";
        break;
    case 'oped':
        echo "<h2>Community: Op-Ed Section Rules and Etiquette</h2><hr>";
        echo "The formal section will host conversations directly tied to specific legislators/legislation. Posts should be of a serious nature,
        and debates should use sources.";
        break;
    case 'Media':
        echo "<h2>Community: Media Section Rules and Etiquette</h2><hr>";
        echo "Coming soon...";
        break;
    default:
        echo "No section defined.";
}

?>