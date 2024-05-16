@extends('layout')

@section('content')
    <form action="{{ route('pet.add') }}" method="POST">
        @csrf
        @method('POST')
        <fieldset>
            <legend>Pet Details</legend>
            <fieldset>
                <legend>Category</legend>
                <label for="category_id">Category ID:</label>
                <input type="number" id="category_id" name="category[id]" required><br>
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category[name]" required><br>
            </fieldset>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <fieldset id="photoUrls_fieldset">
                <legend>Photo URLs</legend>

                <div class="photoUrl">
                    <label for="photoUrl_0">Photo URL:</label>
                    <input type="url" id="photoUrl_0" name="photoUrls[]" required><br>
                </div>
            </fieldset>
            <button type="button" onclick="addPhotoUrl()">Add Photo URL</button><br>
            <fieldset id="tags_fieldset">
                <legend>Tags</legend>
                <div class="tag">
                    <label for="tag_id_0">Tag ID:</label>
                    <input type="number" id="tag_id_0" name="tags[0][id]" required><br>

                    <label for="tag_name_0">Tag Name:</label>
                    <input type="text" id="tag_name_0" name="tags[0][name]" required><br>
                </div>
            </fieldset>
            <button type="button" onclick="addTag()">Add Tag</button><br>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" required><br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>

    <script>
        let tagIndex = 1;
        let photoUrlIndex = 1;

        function addTag() {
            const tagsFieldset = document.getElementById('tags_fieldset');

            const tagDiv = document.createElement('div');
            tagDiv.className = 'tag';

            const tagIdLabel = document.createElement('label');
            tagIdLabel.setAttribute('for', `tag_id_${tagIndex}`);
            tagIdLabel.textContent = 'Tag ID:';
            tagDiv.appendChild(tagIdLabel);

            const tagIdInput = document.createElement('input');
            tagIdInput.type = 'number';
            tagIdInput.id = `tag_id_${tagIndex}`;
            tagIdInput.name = `tags[${tagIndex}][id]`;
            tagDiv.appendChild(tagIdInput);

            const br1 = document.createElement('br');
            tagDiv.appendChild(br1);

            const br2 = document.createElement('br');
            tagDiv.appendChild(br2);

            const tagNameLabel = document.createElement('label');
            tagNameLabel.setAttribute('for', `tag_name_${tagIndex}`);
            tagNameLabel.textContent = 'Tag Name:';
            tagDiv.appendChild(tagNameLabel);

            const tagNameInput = document.createElement('input');
            tagNameInput.type = 'text';
            tagNameInput.id = `tag_name_${tagIndex}`;
            tagNameInput.name = `tags[${tagIndex}][name]`;
            tagDiv.appendChild(tagNameInput);

            const br3 = document.createElement('br');
            tagDiv.appendChild(br3);

            const br4 = document.createElement('br');
            tagDiv.appendChild(br4);

            tagsFieldset.appendChild(tagDiv);

            tagIndex++;
        }

        function addPhotoUrl() {
            const photoUrlsFieldset = document.getElementById('photoUrls_fieldset');

            const photoUrlDiv = document.createElement('div');
            photoUrlDiv.className = 'photoUrl';

            const photoUrlLabel = document.createElement('label');
            photoUrlLabel.setAttribute('for', `photoUrl_${photoUrlIndex}`);
            photoUrlLabel.textContent = 'Photo URL:';
            photoUrlDiv.appendChild(photoUrlLabel);

            const photoUrlInput = document.createElement('input');
            photoUrlInput.type = 'url';
            photoUrlInput.id = `photoUrl_${photoUrlIndex}`;
            photoUrlInput.name = 'photoUrls[]';
            photoUrlInput.required = true;
            photoUrlDiv.appendChild(photoUrlInput);

            const br1 = document.createElement('br');
            photoUrlDiv.appendChild(br1);

            const br2 = document.createElement('br');
            photoUrlDiv.appendChild(br2);

            photoUrlsFieldset.appendChild(photoUrlDiv);

            photoUrlIndex++;
        }
    </script>
@endsection
