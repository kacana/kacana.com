<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\BranchRequest;
use Image;
use Datatables;
use App\models\Branch;


class BranchController extends BaseController {

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.branch.index');
    }

    public function getBranch()
    {
        $branches = Branch::all();
        return Datatables::of($branches)
            ->edit_column('image', function($row) {
                if(!empty($row->image)){
                    return showImage($row->image, BRANCH_IMAGE . showDate($row->created, 1));
                }
            })
            ->edit_column('status', function($row){
                return showSelectStatus($row->id, $row->status, 'Kacana.product.branch.setStatusBranch('.$row->id.', 1)', 'Kacana.product.branch.setStatusBranch('.$row->id.', 0)');
            })
            ->edit_column('created', function($row){
                return showDate($row->created);
            })
            ->edit_column('updated', function($row){
                return showDate($row->updated);
            })
            ->add_column('action', function ($row) {
                return showActionButton('Kacana.product.branch.showEditBranchForm('.$row->id.')', 'Kacana.product.branch.removeBranch('.$row->id.')', true);
            })
            ->make(true);
    }

    /**
     * Save a new branch
     *
     * @param BranchRequest $request
     * @return Response
     */
    public function createBranch(BranchRequest $request)
    {
        $branch = new Branch;
        return $branch->createItem($request->all());
    }

    /**
     * Show edit form branch
     *
     * @param BranchRequest $request
     * @return Response
     */
    public function showEditFormBranch($domain, $id)
    {
        if(!empty($id)){
            $branch = Branch::find($id);
            $data['item'] = $branch;
            return view('admin.branch.form-edit',$data);
        }
    }

    /**
     * Edit branch
     *
     * @param BranchRequest $request
     * @return Response
     */
    public function editBranch(BranchRequest $request)
    {
        $branch = new Branch;
        $id = $request->get('id');
        return $branch->updateItem($id, $request->all());
    }

    /**
     * Set status of branch (0 = inactive; 1 = active)
     *
     * @param idBranch, status
     * @return str
     */
    public function setStatusBranch($domain, $idBranch, $status)
    {
        $str = '';
        $branch = new Branch();
        if($branch->updateItem($idBranch, (array('status'=>$status)))){
            if($status == 0){
                $str = "Đã chuyển sang trạng thái inactive thành công!";
            }else{
                $str = "Đã chuyển sang trạng thái active thành công!";
            }
        }
        return $str;
    }

    /**
     * remove branch
     *
     * @param id
     * @return bool
     */
    public function removeBranch($domain, $id)
    {
        Branch::find($id)->delete();
    }

}
