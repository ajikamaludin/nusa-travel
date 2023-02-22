import React, { useEffect, useRef } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormFile from '@/Components/FormFile';

import TinyEditor from '@/Components/TinyMCE';


export default function Payment(props) {
    const {data, setData, post, processing, errors} = useForm({
        title: '',
        body: '',
        image: '',
        tags: [],
        is_publish: 0
    })


    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleChange = (e) => {
        setData("body", e)
    }

    const handleSubmit = () => {
        post(route('post.store'))
    }

    const file_picker_callback = async (callback, value, meta) => {
      // Provide file and text for the link dialog
      if (meta.filetype == 'file') {
        callback('mypage.html', { text: 'My text' });
      }
  
      // Provide image and alt text for the image dialog
      if (meta.filetype == 'image') {
        console.log(value)
        // const body = new FormData();
        // body.append("_token", props.csrf_token);
        // body.append("image", meta.file);

        // await fetch(route('post.upload'), {
        //   method: "post",
        //   body: body,
        //   headers: {
        //     'accept-content': 'application/json',
        //     'X-CSSRF-TOKEN': props.csrf_token
        //   },
        //   credentials: 'include'
        // }).then(res => res.json())
        // .then(res => {
        //   callback(res.url, { alt: 'My alt text' });
        // })
        callback('imge.jprg', { text: 'My text' });
      }
  
      // Provide alternative source and posted for the media dialog
      if (meta.filetype == 'media') {
        callback('movie.mp4', { source2: 'alt.ogg', poster: 'image.jpg' });
      }
    }

    const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.withCredentials = true;
      xhr.open('POST', route('post.upload'));
    
      xhr.upload.onprogress = (e) => {
        progress(e.loaded / e.total * 100);
      };
    
      xhr.onload = () => {
        if (xhr.status === 403) {
          reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
          return;
        }
    
        if (xhr.status < 200 || xhr.status >= 300) {
          reject('HTTP Error: ' + xhr.status);
          return;
        }
    
        const json = JSON.parse(xhr.responseText);
    
        if (!json || typeof json.url != 'string') {
          reject('Invalid JSON: ' + xhr.responseText);
          return;
        }
    
        resolve(json.url);
      };
    
      xhr.onerror = () => {
        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
      };
    
      const formData = new FormData();
      formData.append("_token", props.csrf_token);
      formData.append('image', blobInfo.blob(), blobInfo.filename());
    
      xhr.send(formData);
    });

    const editorRef = useRef()

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Blog"}
            action={"Post"}
        >
            <Head title="Post" />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col">
                        <div className='text-xl font-bold mb-4'>Post</div>
                        <FormInput
                            name="title"
                            value={data.title}
                            onChange={handleOnChange}
                            label="Title"
                            error={errors.title}
                        />
                        <FormFile
                                label={'Cover Image'}
                                onChange={e => setData('image', e.target.files[0])}
                                error={errors.image}
                            />

                        <TinyEditor
                        onInit={(evt, editor) => editorRef.current = editor}
                        initialValue={data.body}
                        init={{
                          height: 500,
                          // menubar: false,
                          menubar: 'file edit view insert format tools table help',
                          plugins: 'preview importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                          toolbar_mode: 'scrolling',
                          toolbar: 'insertfile image media link anchor codesample | undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | ltr rtl',
                          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                          file_picker_callback: file_picker_callback,
                          images_upload_handler: example_image_upload_handler,
                          // images_upload_url: 'postAcceptor.php',
                          // automatic_uploads: true,
                          promotion: false,
                          image_caption: true,
                          image_advtab: true,
                          object_resizing: true,
                        }}
                />
                        <div className='mt-2'>
                            <Button
                                onClick={handleSubmit}
                                processing={processing} 
                            >
                                Simpan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}