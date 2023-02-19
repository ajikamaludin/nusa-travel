import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import FormInput from '@/Components/FormInput';
import Button from '@/Components/Button';
import { Head, useForm } from '@inertiajs/react';
import FormFile from '@/Components/FormFile';
import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';


export default function Payment(props) {
    const {data, setData, post, processing, errors} = useForm({
        title: '',
        body: '',
        image: '',
    })

    function uploadAdapter(loader) {
        return {
          upload: () => {
            return new Promise((resolve, reject) => {
              const body = new FormData();
              loader.file.then((file) => {
                body.append("image", file);
                // let headers = new Headers();
                // headers.append("Origin", "http://localhost:3000");
                fetch(route('api.upload'), {
                  method: "post",
                  body: body,
                  headers: {
                    'accept-content': 'application/json'
                  }
                  // mode: "no-cors"
                })
                  .then((res) => res.json())
                  .then((res) => {
                    resolve({
                      default: res.url
                    });
                  })
                  .catch((err) => {
                    reject(err);
                  });
              });
            });
          }
        };
      }
      function uploadPlugin(editor) {
        editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
          return uploadAdapter(loader);
        };
      }

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleChange = (e) => {
        setData("body", e)
    }

    const handleSubmit = () => {
        post(route('post.store'))
    }

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Setting"}
            action={"Payment"}
        >
            <Head title="Payment" />

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
                        <CKEditor
                            config={{
                                extraPlugins: [uploadPlugin]
                            }}
                            editor={ClassicEditor}
                            onReady={(editor) => {}}
                            onBlur={(event, editor) => {}}
                            onFocus={(event, editor) => {}}
                            onChange={(event, editor) => {
                                handleChange(editor.getData());
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